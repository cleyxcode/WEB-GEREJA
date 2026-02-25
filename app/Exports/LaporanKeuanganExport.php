<?php

namespace App\Exports;

use App\Models\LaporanKeuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanKeuanganExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnFormatting,
    ShouldAutoSize,
    WithEvents
{
    protected $request;
    protected $total = 0;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = LaporanKeuangan::with('creator')
            ->orderBy('tanggal', 'desc');

        if ($this->request->filled('bulan')) {
            $date = \Carbon\Carbon::parse($this->request->bulan);
            $query->whereYear('tanggal', $date->year)
                  ->whereMonth('tanggal', $date->month);
        }

        if ($this->request->filled('jenis')) {
            $query->where('jenis', $this->request->jenis);
        }

        if ($this->request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $this->request->search . '%');
        }

        $data = $query->get();

        $this->total = $data->sum('jumlah');

        return $data;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis',
            'Keterangan',
            'Jumlah (Rp)',
            'Dibuat Oleh'
        ];
    }

    public function map($row): array
    {
        return [
            $row->tanggal->format('d-m-Y'),
            ucfirst($row->jenis),
            $row->keterangan,
            $row->jumlah,
            $row->creator->name ?? '-',
        ];
    }

    // FORMAT RUPIAH
    public function columnFormats(): array
    {
        return [
            'D' => '"Rp" #,##0_-',
        ];
    }

    // STYLE HEADER
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ]
            ],
        ];
    }

    // TAMBAH STYLE & TOTAL DI BAWAH
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // PERLUAS KOLOM MANUAL
                $sheet->getColumnDimension('A')->setWidth(15);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(40);
                $sheet->getColumnDimension('D')->setWidth(20);
                $sheet->getColumnDimension('E')->setWidth(25);

                // BORDER SEMUA TABEL
                $sheet->getStyle('A1:E' . $lastRow)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // TAMBAH TOTAL
                $totalRow = $lastRow + 1;

                $sheet->setCellValue('C' . $totalRow, 'TOTAL');
                $sheet->setCellValue('D' . $totalRow, $this->total);

                $sheet->getStyle('C' . $totalRow . ':D' . $totalRow)->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ]
                ]);

                // FORMAT RUPIAH UNTUK TOTAL
                $sheet->getStyle('D' . $totalRow)
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0_-');
            },
        ];
    }
}