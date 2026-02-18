<?php

namespace App\Exports;

use App\Models\Borrow;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class BorrowReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithCustomStartCell
{
    protected $startDate;
    protected $endDate;
    protected $rowNumber = 0;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Borrow::with(['user', 'bookItem.book', 'returnBook'])
            ->where('status', 'disetujui')
            ->whereBetween('tanggal_pinjam', [$this->startDate, $this->endDate])
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nomor Identitas',
            'Nama',
            'Judul Buku',
            'Tanggal Peminjam',
            'Tanggal Tempo',
            'Tanggal Kembali',
            'Status'
        ];
    }

    /**
     * @var Borrow $borrow
     */
    public function map($borrow): array
    {
        $this->rowNumber++;

        // Tentukan status
        $status = 'Dipinjam';
        $tanggalKembali = '-';

        if ($borrow->returnBook) {
            $tanggalKembali = Carbon::parse($borrow->returnBook->tanggal_pengembalian)->format('d/m/Y');

            if ($borrow->returnBook->status == 'dikembalikan') {
                $status = 'Dikembalikan';
            } elseif ($borrow->returnBook->status == 'terlambat') {
                $status = 'Terlambat';
            } elseif ($borrow->returnBook->status == 'hilang') {
                $status = 'Hilang';
            } elseif ($borrow->returnBook->status == 'rusak') {
                $status = 'Rusak';
            }
        } else {
            // Cek apakah sudah melewati tanggal tempo
            if ($borrow->tanggal_kembali && Carbon::today()->greaterThan($borrow->tanggal_kembali)) {
                $status = 'Terlambat';
            }
        }

        return [
            $this->rowNumber,
            $borrow->user->nomor_identitas ?? '-',
            $borrow->user->name ?? '-',
            $borrow->bookItem->book->judul ?? '-',
            $borrow->tanggal_pinjam ? $borrow->tanggal_pinjam->format('d/m/Y') : '-',
            $borrow->tanggal_kembali ? $borrow->tanggal_kembali->format('d/m/Y') : '-',
            $tanggalKembali,
            $status
        ];
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A7'; // Data mulai dari baris 7 (setelah header info dan DATA PEMINJAMAN)
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Peminjaman';
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // LANTERA
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LANTERA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Nama Perpustakaan
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'PERPUSTAKAAN SMP NEGERI 1 BALEN');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Title
        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', 'LAPORAN DATA PEMINJAMAN BUKU');
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('1F4788');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Periode
        $periode = Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y');
        $sheet->mergeCells('A4:H4');
        $sheet->setCellValue('A4', 'Periode: ' . $periode);
        $sheet->getStyle('A4')->getFont()->setSize(11);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // DATA PEMINJAMAN (baris 6)
        $sheet->mergeCells('A6:H6');
        $sheet->setCellValue('A6', 'DATA PEMINJAMAN');
        $sheet->getStyle('A6')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F4788']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        // Header row (baris 7)
        $sheet->getStyle('A7:H7')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F4788']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Data rows
        $lastRow = $this->rowNumber + 7;
        $sheet->getStyle('A7:H' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Center alignment untuk kolom No
        $sheet->getStyle('A8:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Auto size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set minimum width
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(30);

        return [];
    }
}
