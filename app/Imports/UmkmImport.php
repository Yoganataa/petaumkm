<?php

namespace App\Imports;

use App\Models\Umkm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UmkmImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nama_usaha'])) {
            return null;
        }

        return new Umkm([
            'nama_usaha' => $row['nama_usaha'] ?? '-',
            'pemilik' => $row['pemilik'] ?? '-',
            'bidang_usaha' => $row['bidang_usaha'] ?? '-',

            // aman untuk header desa / kelurahan_desa / kelurahan
            'desa' => $row['desa']
                ?? $row['kelurahan_desa']
                ?? $row['kelurahan']
                ?? '-',

            'alamat' => $row['alamat'] ?? '-',
            'status_potensi' => strtolower($row['status_potensi'] ?? 'rendah'),
            'latitude' => $row['latitude'] ?? null,
            'longitude' => $row['longitude'] ?? null,
        ]);
    }
}
