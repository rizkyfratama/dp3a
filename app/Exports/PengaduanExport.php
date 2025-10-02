<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengaduanExport implements FromCollection, WithHeadings
{
    /**
     * Ambil koleksi pengaduan tanggal hari ini.
     */
    public function collection()
    {
        return Pengaduan::select(
                'tanggal',
                'nama',
                'no_hp',
                'kategori',
                'isi_pengaduan',
                'lampiran',
                'created_at'
            )
            ->whereDate('created_at', now()->toDateString())
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama',
            'No HP',
            'Kategori',
            'Isi Pengaduan',
            'Lampiran (path)',
            'Waktu Dibuat'
        ];
    }
}
