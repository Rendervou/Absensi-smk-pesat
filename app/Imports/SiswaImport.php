<?php

namespace App\Imports;

use App\Models\DataSiswa;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Throwable;

class SiswaImport implements ToModel, WithStartRow, WithChunkReading, SkipsOnError, SkipsEmptyRows
{
    private $processedCount = 0;
    private $skippedCount = 0;
    private $insertedCount = 0;

    /**
     * Mulai dari baris 11 sesuai dengan Excel Anda
     * (baris 10 adalah header: No, No Induk, Nama Siswa, dll)
     */
    public function startRow(): int
    {
        return 11; // Data dimulai dari baris 11
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function model(array $row)
    {
        $this->processedCount++;

        // Log untuk debugging - lihat struktur row
        Log::info("Processing row #{$this->processedCount}", [
            'row_data' => $row,
            'row_count' => count($row)
        ]);

        // Cek apakah row kosong atau hanya berisi null
        if (empty(array_filter($row, function($value) {
            return !is_null($value) && trim($value) !== '';
        }))) {
            Log::warning("Skip row #{$this->processedCount}: Row kosong");
            $this->skippedCount++;
            return null;
        }

        // Berdasarkan Excel Anda:
        // Kolom A (index 0) = No urut
        // Kolom B (index 1) = No Induk/NIS  
        // Kolom C (index 2) = Nama Siswa
        
        $noInduk = isset($row[1]) ? trim($row[1]) : '';
        $namaSiswa = isset($row[2]) ? trim($row[2]) : '';

        // Skip jika NIS atau nama kosong
        if (empty($noInduk) || empty($namaSiswa)) {
            Log::warning("Skip row #{$this->processedCount}: Data tidak lengkap - NIS: '{$noInduk}', Nama: '{$namaSiswa}'");
            $this->skippedCount++;
            return null;
        }

        // Validasi NIS harus angka
        if (!is_numeric($noInduk)) {
            Log::warning("Skip row #{$this->processedCount}: NIS '{$noInduk}' bukan angka valid");
            $this->skippedCount++;
            return null;
        }

        // Cek duplikat NIS
        if (DataSiswa::where('nis', $noInduk)->exists()) {
            Log::warning("Skip row #{$this->processedCount}: Duplikat NIS '{$noInduk}'");
            $this->skippedCount++;
            return null;
        }

        try {
            // Buat instance model
            $siswa = new DataSiswa([
                'nama_siswa' => $namaSiswa,
                'nis' => $noInduk,
                'no_tlp' => null,
            ]);

            Log::info("Berhasil memproses row #{$this->processedCount}: NIS '{$noInduk}' - '{$namaSiswa}'");
            $this->insertedCount++;

            return $siswa;

        } catch (Throwable $e) {
            Log::error("Error creating model for row #{$this->processedCount}: " . $e->getMessage(), [
                'nis' => $noInduk,
                'nama' => $namaSiswa
            ]);
            $this->skippedCount++;
            return null;
        }
    }

    public function onError(Throwable $error)
    {
        Log::error('Error import row: ' . $error->getMessage());
        $this->skippedCount++;
    }

    public function getSummary()
    {
        return [
            'processed' => $this->processedCount,
            'inserted' => $this->insertedCount,
            'skipped' => $this->skippedCount,
        ];
    }
}