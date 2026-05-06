<?php

namespace App\Exports;

use App\Models\Umkm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UmkmExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        $no = 1;

        return Umkm::get()->map(function ($item) use (&$no) {
            return [
                $no++,
                $item->nama_usaha,
                $item->pemilik,
                $item->bidang_usaha,
                $item->desa,
                $item->alamat,
                $item->status_potensi,
                $item->latitude,
                $item->longitude,
                $item->created_at ? $item->created_at->format('d-m-Y') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Usaha',
            'Pemilik',
            'Bidang Usaha',
            'Desa/Kelurahan',
            'Alamat',
            'Status Potensi',
            'Latitude',
            'Longitude',
            'Tanggal Input',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '35A69F'], // hijau BSI
            ],
        ]);

        return [];
    }
}
