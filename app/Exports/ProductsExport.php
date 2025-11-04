<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ProductsExport implements FromCollection, WithEvents, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ini masih sama
        return Product::select(
            'id',
            'product_name',
            'unit',
            'type',
            'information',
            'qty',
            'producer'
        )->get();
    }

    public function headings(): array
    {
        // Ini masih sama
        return [
            'ID',
            'Nama Produk',
            'Satuan',
            'Tipe',
            'Keterangan',
            'Stok Saat Ini',
            'Produsen',
        ];
    }

    /**
     * TAMBAHKAN FUNGSI BARU INI
     */
    public function startRow(): int
    {
        // headernya mulai di baris 3
        return 3;
    }

    /**
     * TAMBAHKAN FUNGSI BARU INI (WithEvents)
     */
    public function registerEvents(): array
    {
        return [
            // Event ini akan jalan setelah sheet-nya jadi
            AfterSheet::class => function (AfterSheet $event) {
                // Ambil sheet-nya
                $sheet = $event->sheet->getDelegate();

                // --- SETTING JUDUL ---
                // Tulis judul di sel A1
                $sheet->setCellValue('A1', 'LAPORAN DATA PRODUK');

                // Gabungkan sel A1 sampai G1 (sesuai jumlah kolom)
                $sheet->mergeCells('A1:G1');

                // Styling Judul (Tebal, Ukuran 14, Rata Tengah)
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Atur tinggi baris 1 (baris judul)
                $sheet->getRowDimension(1)->setRowHeight(30);

                // (Opsional) Bikin baris 2 jadi spasi kosong
                $sheet->getRowDimension(2)->setRowHeight(5);

                // --- SETTING STYLE HEADER (Baris 3) ---
                // Biar header (baris 3) juga tebal
                $sheet->getStyle('A3:G3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
