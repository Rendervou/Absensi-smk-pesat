<?php

namespace App\Imports;

use App\Models\DataSiswa;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Row data:', $row);

        if (!isset($row['no_induk']) || empty($row['no_induk'])) {
            return null;
        }

        return new DataSiswa([
            'nis'        => $row['no_induk'],
            'nama_siswa' => $row['nama_siswa'] ?? null,
            'no_tlp'     => $row['no_telp'] ?? null,
        ]);
    }
}
