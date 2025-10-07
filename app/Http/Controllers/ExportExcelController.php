<?php

namespace App\Http\Controllers;

use App\Models\DataJurusan;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportExcelController extends Controller
{
    public function exportPerKelas(Request $request)
    {
        ob_end_clean(); // Tambahkan ini untuk membersihkan output buffer
        $semester = $request->get('semester', 1);
        $kelas_filter = $request->get('kelas_filter');

        // Ambil semua kelas - SAMA PERSIS DENGAN AdminController
        $kelasQuery = DataKelas::orderBy('nama_kelas');
        
        // Filter jika ada kelas yang dipilih
        if ($kelas_filter) {
            $kelasQuery->where('id_kelas', $kelas_filter);
        }
        
        $kelas = $kelasQuery->get();

        // Inisialisasi struktur data
        $dataBulan = [];       // [id_kelas][bulan_number] => ['hadir'=>..,'izin'=>..,'sakit'=>..,'alfa'=>..]
        $totalTahunan = [];    // [id_kelas] => totals

        // Loop tiap kelas dan tiap bulan 1..12 - SAMA PERSIS DENGAN AdminController
        foreach ($kelas as $k) {
            $totalTahunan[$k->id_kelas] = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alfa' => 0];

            for ($m = 1; $m <= 12; $m++) {
                // PERBAIKAN: Query dengan id_kelas ATAU nama_kelas
                $counts = Presensi::where(function($query) use ($k) {
                        $query->where('id_kelas', $k->id_kelas)
                              ->orWhere('nama_kelas', $k->nama_kelas);
                    })
                    ->whereMonth('tanggal', $m)
                    ->selectRaw("
                        SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
                        SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin,
                        SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit,
                        SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as alfa
                    ")->first();

                // Pastikan integer
                $h = (int) ($counts->hadir ?? 0);
                $i = (int) ($counts->izin ?? 0);
                $s = (int) ($counts->sakit ?? 0);
                $a = (int) ($counts->alfa ?? 0);

                // Simpan per bulan
                $dataBulan[$k->id_kelas][$m] = [
                    'hadir' => $h,
                    'izin'  => $i,
                    'sakit' => $s,
                    'alfa'  => $a,
                ];

                // Tambah ke total tahunan
                $totalTahunan[$k->id_kelas]['hadir'] += $h;
                $totalTahunan[$k->id_kelas]['izin']  += $i;
                $totalTahunan[$k->id_kelas]['sakit'] += $s;
                $totalTahunan[$k->id_kelas]['alfa']  += $a;
            }
        }

        // Tentukan bulan berdasarkan semester - untuk generate Excel
        $monthNums = $semester == 1 ? [7, 8, 9, 10, 11, 12] : [1, 2, 3, 4, 5, 6];

        return $this->generateExcelPerKelas($kelas, $dataBulan, $totalTahunan, $semester, $monthNums);
    }

    public function exportPerBulan(Request $request)
    {
        ob_end_clean(); // Tambahkan ini untuk membersihkan output buffer
        $bulan = $request->get('bulan', now()->month);
        $id_kelas = $request->get('kelas');
        $selected_jurusan = $request->get('jurusan');
        $search = $request->get('search');

        // Query siswa sama seperti di perBulan
        $siswaQuery = DataSiswa::join('rombels', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
            ->join('data_kelas', 'rombels.id_kelas', '=', 'data_kelas.id_kelas')
            ->join('data_jurusans', 'rombels.id_jurusan', '=', 'data_jurusans.id_jurusan')
            ->select('data_siswas.*', 'data_kelas.nama_kelas', 'data_jurusans.nama_jurusan');

        if ($id_kelas) {
            $siswaQuery->where('data_kelas.id_kelas', $id_kelas);
        }

        if ($selected_jurusan) {
            $siswaQuery->where('data_jurusans.id_jurusan', $selected_jurusan);
        }

        if ($search) {
            $siswaQuery->where(function ($q) use ($search) {
                $q->where('data_siswas.nama_siswa', 'like', "%{$search}%")
                  ->orWhere('data_siswas.nis', 'like', "%{$search}%");
            });
        }

        $siswaList = $siswaQuery->get();

        // Ambil rekap presensi per siswa
        $rekapPresensi = Presensi::select(
                'id_siswa',
                DB::raw("SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as H"),
                DB::raw("SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as S"),
                DB::raw("SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as I"),
                DB::raw("SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as A")
            )
            ->whereMonth('tanggal', $bulan)
            ->groupBy('id_siswa')
            ->get()
            ->keyBy('id_siswa');

        $rekap = [];
        foreach ($siswaList as $siswa) {
            $rekapData = $rekapPresensi[$siswa->id_siswa] ?? null;

            $rekap[] = [
                'nis' => $siswa->nis,
                'nama_siswa' => $siswa->nama_siswa,
                'kelas' => $siswa->nama_kelas ?? '-',
                'kompetensi' => $siswa->nama_jurusan ?? '-',
                'H' => $rekapData->H ?? 0,
                'S' => $rekapData->S ?? 0,
                'I' => $rekapData->I ?? 0,
                'A' => $rekapData->A ?? 0,
            ];
        }

        // Ambil nama kelas untuk header
        $namaKelas = $id_kelas ? DataKelas::find($id_kelas)->nama_kelas : 'SEMUA_KELAS';

        // Generate Excel
        return $this->generateExcel($rekap, $bulan, $namaKelas);
    }

    public function exportDetailSiswa(Request $request, $nis)
    {
        ob_end_clean();
        
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $status = $request->get('status');

        // Ambil data siswa
        $siswa = \App\Models\DataSiswa::where('nis', $nis)->firstOrFail();

        // Ambil data rombel untuk mendapatkan kelas dan jurusan
        $rombel = \App\Models\Rombel::where('id_siswa', $siswa->id_siswa)
            ->join('data_kelas', 'rombels.id_kelas', '=', 'data_kelas.id_kelas')
            ->leftJoin('data_jurusans', 'rombels.id_jurusan', '=', 'data_jurusans.id_jurusan')
            ->select('data_kelas.nama_kelas', 'data_jurusans.nama_jurusan')
            ->first();

        // Query detail presensi dengan filter
        $query = \App\Models\Presensi::where('id_siswa', $siswa->id_siswa)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);
        
        if ($status && in_array($status, ['hadir', 'sakit', 'izin', 'alfa'])) {
            $query->where('status', $status);
        }
        
        $detailPresensi = $query->orderBy('tanggal', 'asc')->get();

        // Hitung statistik
        $allPresensi = \App\Models\Presensi::where('id_siswa', $siswa->id_siswa)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $statistik = [
            'hadir' => $allPresensi->where('status', 'hadir')->count(),
            'sakit' => $allPresensi->where('status', 'sakit')->count(),
            'izin' => $allPresensi->where('status', 'izin')->count(),
            'alfa' => $allPresensi->where('status', 'alfa')->count(),
            'total' => $allPresensi->count()
        ];

        return $this->generateExcelDetailSiswa($siswa, $rombel, $detailPresensi, $statistik, $bulan, $tahun, $status);
    }

    // private function

    private function generateExcel($data, $bulan, $namaKelas)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(8);
        $sheet->getColumnDimension('G')->setWidth(8);
        $sheet->getColumnDimension('H')->setWidth(8);
        $sheet->getColumnDimension('I')->setWidth(8);

        // Title
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'REKAPITULASI KEHADIRAN SISWA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Sub title
        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'SMK INFORMATIKA PESAT');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Semester info
        $sheet->mergeCells('A3:I3');
        $namaBulan = \DateTime::createFromFormat('!m', $bulan)->format('F');
        $tahun = date('Y');
        $sheet->setCellValue('A3', 'SEMESTER GENAP TAHUN PELAJARAN ' . $tahun . '/' . ($tahun + 1));
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Info Kelas
        $sheet->mergeCells('A5:B5');
        $sheet->setCellValue('A5', 'KELAS');
        $sheet->mergeCells('C5:D5');
        $sheet->setCellValue('C5', ': ' . str_replace('_', ' ', $namaKelas));
        $sheet->getStyle('A5:B5')->getFont()->setBold(true);

        // Table Header - Row 7
        $headers = ['NO', 'NIS', 'NAMA', 'KOMPETENSI KEAHLIAN', 'KELAS', 'H', 'S', 'I', 'A'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '7', $header);
            $sheet->getStyle($column . '7')->getFont()->setBold(true);
            $sheet->getStyle($column . '7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($column . '7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            // Background color untuk header
            $sheet->getStyle($column . '7')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFD9E1F2');
            
            $column++;
        }

        // Data rows
        $row = 8;
        $no = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item['nis']);
            $sheet->setCellValue('C' . $row, $item['nama_siswa']);
            $sheet->setCellValue('D' . $row, $item['kompetensi']);
            $sheet->setCellValue('E' . $row, $item['kelas']);
            $sheet->setCellValue('F' . $row, $item['H']);
            $sheet->setCellValue('G' . $row, $item['S']);
            $sheet->setCellValue('H' . $row, $item['I']);
            $sheet->setCellValue('I' . $row, $item['A']);

            // Center alignment untuk nomor dan status
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $row . ':I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Wrap text untuk nama
            $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);

            $row++;
            $no++;
        }

        // Total row
        $totalRow = $row;
        $sheet->mergeCells('A' . $totalRow . ':E' . $totalRow);
        $sheet->setCellValue('A' . $totalRow, 'TOTAL');
        $sheet->getStyle('A' . $totalRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Calculate totals
        $totalH = array_sum(array_column($data, 'H'));
        $totalS = array_sum(array_column($data, 'S'));
        $totalI = array_sum(array_column($data, 'I'));
        $totalA = array_sum(array_column($data, 'A'));

        $sheet->setCellValue('F' . $totalRow, $totalH);
        $sheet->setCellValue('G' . $totalRow, $totalS);
        $sheet->setCellValue('H' . $totalRow, $totalI);
        $sheet->setCellValue('I' . $totalRow, $totalA);

        $sheet->getStyle('F' . $totalRow . ':I' . $totalRow)->getFont()->setBold(true);
        $sheet->getStyle('F' . $totalRow . ':I' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Background color untuk total row
        $sheet->getStyle('A' . $totalRow . ':I' . $totalRow)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE2EFDA');

        // Borders untuk seluruh tabel
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A7:I' . $totalRow)->applyFromArray($styleArray);

        // Set row heights
        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(7)->setRowHeight(25);

        // Generate filename - sanitize
        $namaBulan = \DateTime::createFromFormat('!m', $bulan)->format('F');
        $cleanNamaKelas = preg_replace('/[^A-Za-z0-9]/', '_', $namaKelas);
        $filename = 'Rekap_Kehadiran_' . $cleanNamaKelas . '_' . $namaBulan . '_' . date('Y') . '.xlsx';

        // Return StreamedResponse
        return new StreamedResponse(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    private function generateExcelPerKelas($kelas, $dataBulan, $totalTahunan, $semester, $monthNums)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Nama bulan
        $monthNames = [
            1 => 'JANUARI', 2 => 'FEBRUARI', 3 => 'MARET',
            4 => 'APRIL', 5 => 'MEI', 6 => 'JUNI',
            7 => 'JULI', 8 => 'AGUSTUS', 9 => 'SEPTEMBER',
            10 => 'OKTOBER', 11 => 'NOVEMBER', 12 => 'DESEMBER'
        ];

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);

        // Dynamic column width untuk bulan
        $col = 'C';
        for ($i = 0; $i < count($monthNums); $i++) {
            for ($j = 0; $j < 4; $j++) { // S, I, A, H untuk setiap bulan
                $sheet->getColumnDimension($col)->setWidth(5);
                $col++;
            }
        }
        
        // Width untuk total tidak hadir
        $sheet->getColumnDimension($col)->setWidth(5);
        $sheet->getColumnDimension(++$col)->setWidth(5);
        $sheet->getColumnDimension(++$col)->setWidth(5);

        // Title
        $lastCol = $this->getColumnLetter(2 + (count($monthNums) * 4) + 2);
        $sheet->mergeCells('A1:' . $lastCol . '1');
        $sheet->setCellValue('A1', 'REKAPITULASI KEHADIRAN SISWA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Sub title
        $sheet->mergeCells('A2:' . $lastCol . '2');
        $sheet->setCellValue('A2', 'SMK INFORMATIKA PESAT');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Tahun Pelajaran
        $sheet->mergeCells('A3:' . $lastCol . '3');
        $tahun = date('Y');
        $sheet->setCellValue('A3', 'TAHUN PELAJARAN ' . $tahun . '/' . ($tahun + 1));
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header Row 5 - Bulan
        $currentCol = 'C';
        foreach ($monthNums as $monthNum) {
            $startCol = $currentCol;
            // Merge 4 kolom untuk setiap bulan (S, I, A, H)
            $endCol = $this->getColumnLetter($this->getColumnNumber($currentCol) + 3);
            $sheet->mergeCells($startCol . '5:' . $endCol . '5');
            $sheet->setCellValue($startCol . '5', $monthNames[$monthNum] . ' ' . ($monthNum <= 6 ? $tahun + 1 : $tahun));
            $sheet->getStyle($startCol . '5')->getFont()->setBold(true)->setSize(9);
            $sheet->getStyle($startCol . '5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($startCol . '5')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFD9E1F2');
            
            $currentCol = $this->getColumnLetter($this->getColumnNumber($endCol) + 1);
        }

        // Merge untuk TOTAL TIDAK HADIR
        $totalStartCol = $currentCol;
        $totalEndCol = $this->getColumnLetter($this->getColumnNumber($currentCol) + 2);
        $sheet->mergeCells($totalStartCol . '5:' . $totalEndCol . '5');
        $sheet->setCellValue($totalStartCol . '5', 'TOTAL TIDAK HADIR');
        $sheet->getStyle($totalStartCol . '5')->getFont()->setBold(true)->setSize(9);
        $sheet->getStyle($totalStartCol . '5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($totalStartCol . '5')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFEB3B');

        // Header Row 6 - NO dan KELAS
        $sheet->mergeCells('A5:A6');
        $sheet->setCellValue('A5', 'NO');
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A5')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD9E1F2');

        $sheet->mergeCells('B5:B6');
        $sheet->setCellValue('B5', 'KELAS');
        $sheet->getStyle('B5')->getFont()->setBold(true);
        $sheet->getStyle('B5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('B5')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD9E1F2');

        // Header Row 6 - S, I, A untuk setiap bulan
        $currentCol = 'C';
        foreach ($monthNums as $monthNum) {
            $sheet->setCellValue($currentCol . '6', 'S');
            $sheet->getStyle($currentCol . '6')->getFont()->setBold(true)->setSize(9);
            $sheet->getStyle($currentCol . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . '6')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFD9E1F2');
            $currentCol++;

            $sheet->setCellValue($currentCol . '6', 'I');
            $sheet->getStyle($currentCol . '6')->getFont()->setBold(true)->setSize(9);
            $sheet->getStyle($currentCol . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . '6')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFD9E1F2');
            $currentCol++;

            $sheet->setCellValue($currentCol . '6', 'A');
            $sheet->getStyle($currentCol . '6')->getFont()->setBold(true)->setSize(9);
            $sheet->getStyle($currentCol . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . '6')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFD9E1F2');
            $currentCol++;
            
            // Skip H column space
            $currentCol++;
        }

        // Header untuk Total (S, I, A)
        $sheet->setCellValue($currentCol . '6', 'S');
        $sheet->getStyle($currentCol . '6')->getFont()->setBold(true)->setSize(9);
        $sheet->getStyle($currentCol . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($currentCol . '6')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFEB3B');
        $currentCol++;

        $sheet->setCellValue($currentCol . '6', 'I');
        $sheet->getStyle($currentCol . '6')->getFont()->setBold(true)->setSize(9);
        $sheet->getStyle($currentCol . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($currentCol . '6')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFEB3B');
        $currentCol++;

        $sheet->setCellValue($currentCol . '6', 'A');
        $sheet->getStyle($currentCol . '6')->getFont()->setBold(true)->setSize(9);
        $sheet->getStyle($currentCol . '6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($currentCol . '6')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFEB3B');

        // Data rows
        $row = 7;
        $no = 1;
        foreach ($kelas as $k) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $k->nama_kelas);
            
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $currentCol = 'C';
            
            // Hitung ulang total untuk semester yang dipilih saja
            $totalSemester = ['sakit' => 0, 'izin' => 0, 'alfa' => 0];
            
            foreach ($monthNums as $monthNum) {
                $data = $dataBulan[$k->id_kelas][$monthNum] ?? ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alfa' => 0];
                
                // S
                $sheet->setCellValue($currentCol . $row, $data['sakit']);
                $sheet->getStyle($currentCol . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $totalSemester['sakit'] += $data['sakit'];
                $currentCol++;

                // I
                $sheet->setCellValue($currentCol . $row, $data['izin']);
                $sheet->getStyle($currentCol . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $totalSemester['izin'] += $data['izin'];
                $currentCol++;

                // A
                $sheet->setCellValue($currentCol . $row, $data['alfa']);
                $sheet->getStyle($currentCol . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $totalSemester['alfa'] += $data['alfa'];
                $currentCol++;
                
                // Skip H
                $currentCol++;
            }

            // Total - gunakan total semester yang baru dihitung
            $sheet->setCellValue($currentCol . $row, $totalSemester['sakit']);
            $sheet->getStyle($currentCol . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . $row)->getFont()->setBold(true);
            $currentCol++;

            $sheet->setCellValue($currentCol . $row, $totalSemester['izin']);
            $sheet->getStyle($currentCol . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . $row)->getFont()->setBold(true);
            $currentCol++;

            $sheet->setCellValue($currentCol . $row, $totalSemester['alfa']);
            $sheet->getStyle($currentCol . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($currentCol . $row)->getFont()->setBold(true);

            $row++;
            $no++;
        }

        // Borders untuk seluruh tabel
        $lastDataCol = $this->getColumnLetter(2 + (count($monthNums) * 4) + 2);
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle('A5:' . $lastDataCol . ($row - 1))->applyFromArray($styleArray);

        // Set row heights
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(6)->setRowHeight(20);

        // Generate filename
        $semesterText = $semester == 1 ? 'Semester_1' : 'Semester_2';
        $kelasText = count($kelas) == 1 ? preg_replace('/[^A-Za-z0-9]/', '_', $kelas[0]->nama_kelas) : 'Semua_Kelas';
        $filename = 'Rekap_Kehadiran_Perkelas_' . $kelasText . '_' . $semesterText . '_' . date('Y') . '.xlsx';

        // Return StreamedResponse
        return new StreamedResponse(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    // Helper function untuk konversi nomor kolom ke huruf
    private function getColumnLetter($columnNumber)
    {
        $letter = '';
        while ($columnNumber > 0) {
            $temp = ($columnNumber - 1) % 26;
            $letter = chr($temp + 65) . $letter;
            $columnNumber = ($columnNumber - $temp - 1) / 26;
        }
        return $letter;
    }

    // Helper function untuk konversi huruf kolom ke nomor
    private function getColumnNumber($columnLetter)
    {
        $columnNumber = 0;
        $length = strlen($columnLetter);
        for ($i = 0; $i < $length; $i++) {
            $columnNumber = $columnNumber * 26 + (ord($columnLetter[$i]) - 64);
        }
        return $columnNumber;
    }

    private function generateExcelDetailSiswa($siswa, $rombel, $detailPresensi, $statistik, $bulan, $tahun, $status)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Nama bulan
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Set column widths - DIPERLEBAR
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

        // ==================== HEADER SECTION ====================
        
        // Title - Row 1
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A1', 'LAPORAN PRESENSI SISWA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF2E5090');
        $sheet->getRowDimension(1)->setRowHeight(30);

        // School Name - Row 2
        $sheet->mergeCells('A2:F2');
        $sheet->setCellValue('A2', 'SMK INFORMATIKA PESAT');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $sheet->getStyle('A2')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF5B9BD5');
        $sheet->getRowDimension(2)->setRowHeight(25);

        // Period - Row 3
        $sheet->mergeCells('A3:F3');
        $sheet->setCellValue('A3', 'PERIODE: ' . strtoupper($namaBulan[$bulan]) . ' ' . $tahun);
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A3')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFDAE3F3');
        $sheet->getRowDimension(3)->setRowHeight(22);

        // Empty row
        $sheet->getRowDimension(4)->setRowHeight(8);

        // ==================== INFORMASI SISWA SECTION ====================
        
        $currentRow = 5;
        
        // Header Info Siswa
        $sheet->mergeCells("A{$currentRow}:F{$currentRow}");
        $sheet->setCellValue("A{$currentRow}", 'INFORMASI SISWA');
        $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true)->setSize(12)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $sheet->getStyle("A{$currentRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$currentRow}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF70AD47');
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $currentRow++;

        // Data Siswa - Format Tabel 2 Kolom
        $infoData = [
            ['NIS', ': ' . $siswa->nis],
            ['Nama Lengkap', ': ' . $siswa->nama_siswa],
            ['Kelas', ': ' . ($rombel->nama_kelas ?? '-')],
            ['Jurusan', ': ' . ($rombel->nama_jurusan ?? '-')],
        ];

        foreach ($infoData as $info) {
            $sheet->setCellValue("A{$currentRow}", $info[0]);
            $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle("A{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$currentRow}")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE2EFDA');
            
            $sheet->mergeCells("B{$currentRow}:F{$currentRow}");
            $sheet->setCellValue("B{$currentRow}", $info[1]);
            $sheet->getStyle("B{$currentRow}")->getFont()->setSize(11);
            $sheet->getStyle("B{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            
            $sheet->getRowDimension($currentRow)->setRowHeight(20);
            $currentRow++;
        }

        // Border untuk info siswa
        $infoEndRow = $currentRow - 1;
        $sheet->getStyle("A5:F{$infoEndRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Empty row
        $currentRow++;
        $sheet->getRowDimension($currentRow)->setRowHeight(8);
        $currentRow++;

        // ==================== STATISTIK SECTION ====================
        
        // Header Statistik
        $sheet->mergeCells("A{$currentRow}:F{$currentRow}");
        $sheet->setCellValue("A{$currentRow}", 'STATISTIK KEHADIRAN');
        $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true)->setSize(12)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $sheet->getStyle("A{$currentRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$currentRow}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFC000');
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $statsStartRow = $currentRow;
        $currentRow++;

        // Statistik Table Header
        $sheet->setCellValue("A{$currentRow}", 'KETERANGAN');
        $sheet->setCellValue("B{$currentRow}", 'TOTAL');
        $sheet->setCellValue("C{$currentRow}", 'HADIR');
        $sheet->setCellValue("D{$currentRow}", 'SAKIT');
        $sheet->setCellValue("E{$currentRow}", 'IZIN');
        $sheet->setCellValue("F{$currentRow}", 'ALFA');
        
        $sheet->getStyle("A{$currentRow}:F{$currentRow}")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("A{$currentRow}:F{$currentRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$currentRow}:F{$currentRow}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD9D9D9');
        $sheet->getRowDimension($currentRow)->setRowHeight(22);
        $currentRow++;

        // Statistik Data
        $sheet->setCellValue("A{$currentRow}", 'Jumlah Hari');
        $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("A{$currentRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$currentRow}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFF2F2F2');
        
        // Data dengan warna berbeda
        $statsData = [
            ['col' => 'B', 'value' => $statistik['total'], 'color' => 'FFB4C7E7'],
            ['col' => 'C', 'value' => $statistik['hadir'], 'color' => 'FFC6E0B4'],
            ['col' => 'D', 'value' => $statistik['sakit'], 'color' => 'FF9BC2E6'],
            ['col' => 'E', 'value' => $statistik['izin'], 'color' => 'FFFFD966'],
            ['col' => 'F', 'value' => $statistik['alfa'], 'color' => 'FFF4B084'],
        ];
        
        foreach ($statsData as $data) {
            $sheet->setCellValue($data['col'] . $currentRow, $data['value']);
            $sheet->getStyle($data['col'] . $currentRow)->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle($data['col'] . $currentRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($data['col'] . $currentRow)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB($data['color']);
        }
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $currentRow++;

        // Persentase Kehadiran
        $persentase = $statistik['total'] > 0 ? number_format(($statistik['hadir'] / $statistik['total']) * 100, 1) : 0;
        
        $sheet->mergeCells("A{$currentRow}:D{$currentRow}");
        $sheet->setCellValue("A{$currentRow}", 'PERSENTASE KEHADIRAN');
        $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle("A{$currentRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$currentRow}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE2EFDA');
        
        $sheet->mergeCells("E{$currentRow}:F{$currentRow}");
        $sheet->setCellValue("E{$currentRow}", $persentase . '%');
        $sheet->getStyle("E{$currentRow}")->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle("E{$currentRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        
        // Color based on percentage
        $percentColor = $persentase >= 90 ? 'FF70AD47' : ($persentase >= 75 ? 'FFFFC000' : 'FFE74C3C');
        $sheet->getStyle("E{$currentRow}:F{$currentRow}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB($percentColor);
        $sheet->getStyle("E{$currentRow}:F{$currentRow}")->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        
        // Border untuk statistik
        $statsEndRow = $currentRow;
        $sheet->getStyle("A{$statsStartRow}:F{$statsEndRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
        
        $currentRow++;

        // Empty row
        $currentRow++;
        $sheet->getRowDimension($currentRow)->setRowHeight(8);
        $currentRow++;

        // ==================== RIWAYAT PRESENSI SECTION ====================
        
        // Header Riwayat
        $sheet->mergeCells("A{$currentRow}:F{$currentRow}");
        $statusText = $status ? ' - FILTER: ' . strtoupper($status) : '';
        $sheet->setCellValue("A{$currentRow}", 'RIWAYAT PRESENSI HARIAN' . $statusText);
        $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true)->setSize(12)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
        $sheet->getStyle("A{$currentRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$currentRow}")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF2E5090');
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $riwayatStartRow = $currentRow;
        $currentRow++;

        // Table Headers
        $headers = ['NO', 'TANGGAL', 'HARI', 'STATUS', 'WAKTU ABSEN', 'KETERANGAN'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $currentRow, $header);
            $sheet->getStyle($col . $currentRow)->getFont()->setBold(true)->setSize(11);
            $sheet->getStyle($col . $currentRow)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($col . $currentRow)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF5B9BD5');
            $sheet->getStyle($col . $currentRow)->getFont()->getColor()->setARGB('FFFFFFFF');
            $col++;
        }
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $currentRow++;

        // Data Rows
        $no = 1;
        $startDataRow = $currentRow;
        
        if ($detailPresensi->count() > 0) {
            foreach ($detailPresensi as $presensi) {
                $tanggal = \Carbon\Carbon::parse($presensi->tanggal);
                
                // NO
                $sheet->setCellValue("A{$currentRow}", $no);
                $sheet->getStyle("A{$currentRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                
                // TANGGAL
                $sheet->setCellValue("B{$currentRow}", $tanggal->format('d/m/Y'));
                $sheet->getStyle("B{$currentRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                
                // HARI
                $sheet->setCellValue("C{$currentRow}", $tanggal->locale('id')->isoFormat('dddd'));
                $sheet->getStyle("C{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                
                // STATUS dengan color coding
                $statusText = strtoupper($presensi->status);
                $sheet->setCellValue("D{$currentRow}", $statusText);
                $sheet->getStyle("D{$currentRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("D{$currentRow}")->getFont()->setBold(true)->setSize(11);
                
                // Color based on status
                $statusColors = [
                    'HADIR' => ['bg' => 'FFC6E0B4', 'text' => 'FF006100'],
                    'SAKIT' => ['bg' => 'FF9BC2E6', 'text' => 'FF0C2C84'],
                    'IZIN' => ['bg' => 'FFFFD966', 'text' => 'FF7F6000'],
                    'ALFA' => ['bg' => 'FFF4B084', 'text' => 'FF7F2704']
                ];
                
                if (isset($statusColors[$statusText])) {
                    $sheet->getStyle("D{$currentRow}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB($statusColors[$statusText]['bg']);
                    $sheet->getStyle("D{$currentRow}")->getFont()
                        ->getColor()->setARGB($statusColors[$statusText]['text']);
                }
                
                // WAKTU
                $waktu = \Carbon\Carbon::parse($presensi->created_at)->format('H:i');
                $sheet->setCellValue("E{$currentRow}", $waktu . ' WIB');
                $sheet->getStyle("E{$currentRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                
                // KETERANGAN
                $sheet->setCellValue("F{$currentRow}", '-');
                $sheet->getStyle("F{$currentRow}")->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                
                // Alternating row colors
                if ($no % 2 == 0) {
                    $cols = ['A', 'B', 'C', 'E', 'F'];
                    foreach ($cols as $c) {
                        $sheet->getStyle($c . $currentRow)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFF2F2F2');
                    }
                }
                
                $sheet->getStyle("A{$currentRow}:F{$currentRow}")->getFont()->setSize(10);
                $sheet->getRowDimension($currentRow)->setRowHeight(20);
                $currentRow++;
                $no++;
            }
        } else {
            $sheet->mergeCells("A{$currentRow}:F{$currentRow}");
            $sheet->setCellValue("A{$currentRow}", 'Tidak ada data presensi untuk periode ini');
            $sheet->getStyle("A{$currentRow}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$currentRow}")->getFont()->setItalic(true)->setSize(11);
            $sheet->getStyle("A{$currentRow}")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFF2CC');
            $sheet->getRowDimension($currentRow)->setRowHeight(30);
            $currentRow++;
        }

        // Border untuk tabel riwayat
        $riwayatEndRow = $currentRow - 1;
        $sheet->getStyle("A{$riwayatStartRow}:F{$riwayatEndRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // ==================== FOOTER ====================
        
        $currentRow += 2;
        $sheet->mergeCells("A{$currentRow}:F{$currentRow}");
        $sheet->setCellValue("A{$currentRow}", 'Dicetak pada: ' . now()->format('d F Y, H:i:s') . ' WIB');
        $sheet->getStyle("A{$currentRow}")->getFont()->setSize(9)->setItalic(true);
        $sheet->getStyle("A{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Generate filename
        $cleanNama = preg_replace('/[^A-Za-z0-9]/', '_', $siswa->nama_siswa);
        $filename = 'Detail_Presensi_' . $cleanNama . '_' . $namaBulan[$bulan] . '_' . $tahun . '.xlsx';

        return new StreamedResponse(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}