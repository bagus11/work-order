<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as StyleBorder;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OPXPivotExport implements FromArray, WithStyles, WithEvents
{
    protected $data;
    protected $months;
    protected $locations;
    protected $categoryMerge = [];

    public function __construct($data, $months, $locations)
    {
        $this->data      = $data;
        $this->months    = $months;
        $this->locations = $locations;
        
    }

     public function array(): array
    {
        // Row pertama: header bulan (merged)
        $header1 = ['Category', 'Item List'];
        foreach ($this->months as $m) {
            $header1[] = $m['name'];
            for ($i = 1; $i < count($this->locations) + 1; $i++) {
                $header1[] = '';
            }
        }

        // Row kedua: lokasi + total
        $header2 = ['', ''];
        foreach ($this->months as $m) {
            foreach ($this->locations as $loc) {
                $header2[] = $loc;
            }
            $header2[] = 'Total';
        }

        $rows = [$header1, $header2];
        $lastCategory = null;
        $categoryStartRow = 3; // Mulai dari baris data
        $rowIndex = 3;
        // Array untuk menghitung total bawah
        $footerTotals = [];
        foreach ($this->months as $m) {
            foreach ($this->locations as $loc) {
                $footerTotals["{$m['name']}_{$loc}"] = 0;
            }
            $footerTotals["{$m['name']}_Total"] = 0;
        }

        // Data utama
        foreach ($this->data as $row) {
            if ($row['category'] !== $lastCategory) {
                // Jika ada kategori sebelumnya, merge range sebelumnya
                if ($lastCategory !== null && $rowIndex - 1 > $categoryStartRow) {
                    $this->categoryMerge[] = [
                        'col'  => 'A',
                        'from' => $categoryStartRow,
                        'to'   => $rowIndex - 1
                    ];
                }
                $categoryStartRow = $rowIndex;
                $lastCategory = $row['category'];
                $categoryName = $row['category'];
            } else {
                $categoryName = ''; // Hilangkan teks jika kategori sama
            }

            $line = [$categoryName, $row['product']];
            foreach ($this->months as $m) {
                foreach ($this->locations as $loc) {
                    $val = (float) ($row["{$m['name']}_{$loc}"] ?? 0);
                    $line[] = $val;
                    $footerTotals["{$m['name']}_{$loc}"] += $val;
                }
                $totalMonth = (float) ($row["{$m['name']}_Total"] ?? 0);
                $line[] = $totalMonth;
                $footerTotals["{$m['name']}_Total"] += $totalMonth;
            }
            $rows[] = $line;
            $rowIndex++;
        }

        // Merge kategori terakhir
        if ($lastCategory !== null && $rowIndex - 1 > $categoryStartRow) {
            $this->categoryMerge[] = [
                'col'  => 'A',
                'from' => $categoryStartRow,
                'to'   => $rowIndex - 1
            ];
        }


        // Footer TOTAL
        $footerLine = ['TOTAL', ''];
        foreach ($this->months as $m) {
            foreach ($this->locations as $loc) {
                $footerLine[] = $footerTotals["{$m['name']}_{$loc}"];
            }
            $footerLine[] = $footerTotals["{$m['name']}_Total"];
        }
        $rows[] = $footerLine;

        return $rows;
    }

  public function styles(Worksheet $sheet)
{
    $highestRow    = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $headerRange   = "A1:{$highestColumn}2";

    // Bold header
    $sheet->getStyle($headerRange)->getFont()->setBold(true);

    // Background header biru
    $sheet->getStyle($headerRange)->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('4F81BD');

    // Font putih di header
    $sheet->getStyle($headerRange)->getFont()->getColor()->setARGB('FFFFFF');

    // Border seluruh tabel
    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
        ->getBorders()->getAllBorders()->setBorderStyle(StyleBorder::BORDER_THIN);

    // Center header
    $sheet->getStyle($headerRange)->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
        ->setVertical(Alignment::VERTICAL_CENTER);

    // Bold + Background kuning untuk baris TOTAL
    $footerRange = "A{$highestRow}:{$highestColumn}{$highestRow}";
    $sheet->getStyle($footerRange)->getFont()->setBold(true);
    $sheet->getStyle($footerRange)->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFF200'); // Kuning terang

    // Rata kanan untuk angka mulai kolom C
    $sheet->getStyle("C3:{$highestColumn}{$highestRow}")
        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    // Format angka jadi Rupiah
    $sheet->getStyle("C3:{$highestColumn}{$highestRow}")
        ->getNumberFormat()->setFormatCode('"" #,##0');
}


 public function registerEvents(): array 
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            // Merge untuk "Category" dan "Item List"
            $sheet->mergeCells('A1:A2');
            $sheet->mergeCells('B1:B2');
            $sheet->getColumnDimension('A')->setWidth(20); // Category
            $sheet->getColumnDimension('B')->setWidth(15); // Item List

            // Merge per bulan
            $startCol = 3; // Kolom C
            foreach ($this->months as $m) {
                $endCol = $startCol + count($this->locations);

                // Ambil range kolom untuk merge
                $colRange = $sheet->getCellByColumnAndRow($startCol, 1)->getColumn() . '1:' .
                            $sheet->getCellByColumnAndRow($endCol, 1)->getColumn() . '1';

                // Merge cell
                $sheet->mergeCells($colRange);

                // Set auto width + padding untuk tiap kolom
                for ($col = $startCol; $col <= $endCol; $col++) {
                    $columnLetter = $sheet->getCellByColumnAndRow($col, 1)->getColumn();
                    $sheet->getColumnDimension($columnLetter)->setAutoSize(true);
                    // Tambahkan sedikit padding width
                    $currentWidth = $sheet->getColumnDimension($columnLetter)->getWidth();
                    $sheet->getColumnDimension($columnLetter)->setWidth($currentWidth + 2);
                }

                $startCol = $endCol + 1;
            }
  // Merge kolom Category
                foreach ($this->categoryMerge as $merge) {
                    $sheet->mergeCells("{$merge['col']}{$merge['from']}:{$merge['col']}{$merge['to']}");
                    $sheet->getStyle("{$merge['col']}{$merge['from']}:{$merge['col']}{$merge['to']}")
                        ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                }

            // Auto-size semua kolom
            foreach (range('A', $sheet->getHighestColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
                // --- Highlight background kuning untuk semua kolom "Total" ---
            $highestRow = $sheet->getHighestRow();
            $colIndex = 3; // Mulai dari kolom C
            foreach ($this->months as $m) {
                 $totalColIndex = $startCol + count($this->locations);
                $totalColLetter = $sheet->getCellByColumnAndRow($totalColIndex, 2)->getColumn();

                // Warnai kolom "Total" di baris 1 dan 2
                $sheet->getStyle("{$totalColLetter}1:{$totalColLetter}2")
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF200'); // Kuning

                // Warna font hitam untuk header "Total"
                $sheet->getStyle("{$totalColLetter}1:{$totalColLetter}2")
                    ->getFont()->getColor()->setARGB('000000'); // Hitam

                $startCol = $totalColIndex + 1;
            }

            // **Force autosize calculation**
            $sheet->calculateColumnWidths();
        },
    ];
}

}
