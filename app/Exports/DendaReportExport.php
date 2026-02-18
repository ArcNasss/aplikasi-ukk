<?php

namespace App\Exports;

use App\Models\Borrow;
use App\Models\ReturnBook;
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

class DendaReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithCustomStartCell
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
        // Ambil denda dari borrows (belum dikembalikan, lewat tempo)
        $dendaFromBorrows = Borrow::with(['user', 'bookItem.book'])
            ->where('status', 'disetujui')
            ->whereDate('tanggal_kembali', '<', Carbon::today())
            ->whereBetween('tanggal_pinjam', [$this->startDate, $this->endDate])
            ->whereNotIn('id', function($query) {
                $query->select('borrows_id')->from('return_books');
            })
            ->get()
            ->map(function($borrow) {
                $hariTerlambat = Carbon::today()->diffInDays($borrow->tanggal_kembali);
                $denda = $hariTerlambat * 2000;

                return (object)[
                    'user_name' => $borrow->user->name,
                    'user_nomor_identitas' => $borrow->user->nomor_identitas,
                    'book_title' => $borrow->bookItem->book->judul ?? '-',
                    'book_code' => $borrow->bookItem->kode_buku ?? '-',
                    'tanggal_pinjam' => $borrow->tanggal_pinjam,
                    'tanggal_tempo' => $borrow->tanggal_kembali,
                    'tanggal_pengembalian' => null,
                    'jenis_denda' => 'Terlambat',
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $denda,
                    'is_paid' => false,
                ];
            });

        // Ambil denda dari return_books (sudah dikembalikan dengan denda)
        $dendaFromReturns = ReturnBook::with(['borrow.user', 'borrow.bookItem.book'])
            ->whereIn('status', ['terlambat', 'hilang', 'rusak'])
            ->where('denda', '>', 0)
            ->whereBetween('tanggal_pengembalian', [$this->startDate, $this->endDate])
            ->get()
            ->map(function($return) {
                $hariTerlambat = null;
                if ($return->status == 'terlambat') {
                    $hariTerlambat = Carbon::parse($return->tanggal_pengembalian)
                        ->diffInDays($return->borrow->tanggal_kembali);
                }

                return (object)[
                    'user_name' => $return->borrow->user->name ?? '-',
                    'user_nomor_identitas' => $return->borrow->user->nomor_identitas ?? '-',
                    'book_title' => $return->borrow->bookItem->book->judul ?? '-',
                    'book_code' => $return->borrow->bookItem->kode_buku ?? '-',
                    'tanggal_pinjam' => $return->borrow->tanggal_pinjam,
                    'tanggal_tempo' => $return->borrow->tanggal_kembali,
                    'tanggal_pengembalian' => $return->tanggal_pengembalian,
                    'jenis_denda' => ucfirst($return->status),
                    'hari_terlambat' => $hariTerlambat,
                    'denda' => $return->denda,
                    'is_paid' => $return->is_paid ?? false,
                ];
            });

        // Gabungkan dan urutkan berdasarkan denda terbesar
        return $dendaFromBorrows->concat($dendaFromReturns)->sortByDesc('denda')->values();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nomor Identitas',
            'Judul Buku',
            'Kode Buku',
            'Tanggal Peminjaman',
            'Tempo',
            'Tanggal Kembali',
            'Jenis Denda',
            'Jumlah Keterlambatan',
            'Jumlah Denda',
            'Status'
        ];
    }

    /**
     * @var object $denda
     */
    public function map($denda): array
    {
        $this->rowNumber++;
        
        return [
            $this->rowNumber,
            $denda->user_name,
            $denda->user_nomor_identitas,
            $denda->book_title,
            $denda->book_code,
            $denda->tanggal_pinjam ? Carbon::parse($denda->tanggal_pinjam)->format('d/m/Y') : '-',
            $denda->tanggal_tempo ? Carbon::parse($denda->tanggal_tempo)->format('d/m/Y') : '-',
            $denda->tanggal_pengembalian ? Carbon::parse($denda->tanggal_pengembalian)->format('d/m/Y') : '-',
            $denda->jenis_denda,
            $denda->hari_terlambat ? $denda->hari_terlambat . ' Hari' : '-',
            'Rp. ' . number_format($denda->denda, 0, ',', '.'),
            $denda->is_paid ? 'Dibayar' : 'Belum'
        ];
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A7'; // Data mulai dari baris 7
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Denda';
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // LANTERA
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', 'LANTERA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Nama Perpustakaan
        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A2', 'PERPUSTAKAAN SMP NEGERI 1 BALEN');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Title
        $sheet->mergeCells('A3:L3');
        $sheet->setCellValue('A3', 'LAPORAN DATA REKAP DENDA');
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(16)->getColor()->setRGB('1F4788');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Periode
        $periode = Carbon::parse($this->startDate)->format('d/m/Y') . ' - ' . Carbon::parse($this->endDate)->format('d/m/Y');
        $sheet->mergeCells('A4:L4');
        $sheet->setCellValue('A4', 'Periode: ' . $periode);
        $sheet->getStyle('A4')->getFont()->setSize(11);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // DATA REKAP DENDA (baris 6)
        $sheet->mergeCells('A6:L6');
        $sheet->setCellValue('A6', 'DATA REKAP DENDA');
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
        $sheet->getStyle('A7:L7')->applyFromArray([
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
        $sheet->getStyle('A7:L' . $lastRow)->applyFromArray([
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
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set minimum width
        $sheet->getColumnDimension('B')->setWidth(20); // Nama
        $sheet->getColumnDimension('C')->setWidth(15); // Nomor Identitas
        $sheet->getColumnDimension('D')->setWidth(30); // Judul Buku
        $sheet->getColumnDimension('K')->setWidth(15); // Jumlah Denda

        return [];
    }
}
