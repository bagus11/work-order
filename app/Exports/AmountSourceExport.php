<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border as StyleBorder;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class AmountSourceExport implements FromArray, WithStyles, WithEvents, ShouldAutoSize
{
    protected $pivotKeys;
    protected $data;
    protected $months;
    protected $locations;
    protected $types = ['PR', 'PO', 'IS'];
    protected $categoryMerge = []; // Untuk merge kategori

    public function __construct(array $pivotKeys, array $data, array $months, array $locations)
    {
        $this->pivotKeys = $pivotKeys;
        $this->data      = $data;
        $this->months    = $months;
        $this->locations = $locations;
    }

    public function array(): array
    {
        // ============== HEADER ==============
        $header1 = ['Category', 'Product'];
        foreach ($this->months as $m) {
            $header1[] = $m['name'];
            for ($i = 1; $i < count($this->locations) * count($this->types); $i++) {
                $header1[] = '';
            }
        }

        $header2 = ['', ''];
        foreach ($this->months as $m) {
            foreach ($this->locations as $loc) {
                $header2[] = $loc;
                for ($i = 1; $i < count($this->types); $i++) {
                    $header2[] = '';
                }
            }
        }

        $header3 = ['', ''];
        foreach ($this->months as $m) {
            foreach ($this->locations as $loc) {
                foreach ($this->types as $type) {
                    $header3[] = $type;
                }
            }
        }

        $rows = [$header1, $header2, $header3];

        // ============== ISI DATA ==============
        $groupedData = [];
        foreach ($this->data as $item) {
            $key = "{$item['category']}_{$item['product']}";

            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [
                    'category' => $item['category'],
                    'product'  => $item['product']
                ];
                foreach ($this->months as $m) {
                    foreach ($this->locations as $loc) {
                        foreach ($this->types as $type) {
                            $groupedData[$key]["{$m['name']}_{$loc}_{$type}"] = '';
                        }
                    }
                }
            }

            // Gabungkan data dengan "\n"
            foreach ($item as $col => $val) {
                if (!in_array($col, ['category','product'])) {
                    if (!empty($groupedData[$key][$col])) {
                        $groupedData[$key][$col] .= "\n" . $val;
                    } else {
                        $groupedData[$key][$col] = $val;
                    }
                }
            }
        }

        // Group by Category untuk merge
        $categoryGrouped = [];
        foreach ($this->pivotKeys as $key) {
            if (!isset($groupedData[$key])) {
                [$category, $product] = explode('_', $key);
                $groupedData[$key] = [
                    'category' => $category,
                    'product'  => $product
                ];
                foreach ($this->months as $m) {
                    foreach ($this->locations as $loc) {
                        foreach ($this->types as $type) {
                            $groupedData[$key]["{$m['name']}_{$loc}_{$type}"] = '';
                        }
                    }
                }
            }

            $cat = explode('_', $key)[0];
            if (!isset($categoryGrouped[$cat])) {
                $categoryGrouped[$cat] = [];
            }
            $categoryGrouped[$cat][] = $groupedData[$key];
        }

        // Buat rows + catat merge info
        $currentRow = 4;
        foreach ($categoryGrouped as $cat => $items) {
            $startRow = $currentRow;

            foreach ($items as $row) {
                $line = [$row['category'], $row['product']];
                foreach ($this->months as $m) {
                    foreach ($this->locations as $loc) {
                        foreach ($this->types as $type) {
                            $line[] = $row["{$m['name']}_{$loc}_{$type}"];
                        }
                    }
                }
                $rows[] = $line;
                $currentRow++;
            }

            if (count($items) > 1) {
                $this->categoryMerge[] = [
                    'col'  => 'A',
                    'from' => $startRow,
                    'to'   => $currentRow - 1,
                ];
            }
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
{
    $highestRow    = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $headerRange   = "A1:{$highestColumn}3";

    // Style header
    $sheet->getStyle($headerRange)->applyFromArray([
        'font' => [
            'bold'  => true,
            'color' => ['argb' => 'FFFFFF']
        ],
        'fill' => [
            'fillType'   => Fill::FILL_SOLID,
            'startColor' => ['argb' => '4F81BD']
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical'   => Alignment::VERTICAL_CENTER,
            'wrapText'   => true,
        ],
    ]);

    // Border all cells
    $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
        ->getBorders()->getAllBorders()->setBorderStyle(StyleBorder::BORDER_THIN);

    // WrapText untuk semua data cell
    $sheet->getStyle("A4:{$highestColumn}{$highestRow}")
        ->getAlignment()->setWrapText(true);

    // Middle align + left align untuk PR, PO, IS (kolom data)
    $sheet->getStyle("C4:{$highestColumn}{$highestRow}")
        ->getAlignment()
        ->setHorizontal(Alignment::HORIZONTAL_LEFT)
        ->setVertical(Alignment::VERTICAL_CENTER);

    // Merge "Category" and "Product"
    $sheet->mergeCells('A1:A3');
    $sheet->mergeCells('B1:B3');

    // Merge bulan & lokasi
    $colIndex = 3;
    foreach ($this->months as $m) {
        $startMonthCol = $colIndex;
        foreach ($this->locations as $loc) {
            $startLocCol = $colIndex;
            $endLocCol   = $startLocCol + count($this->types) - 1;
            $sheet->mergeCellsByColumnAndRow($startLocCol, 2, $endLocCol, 2);
            $colIndex = $endLocCol + 1;
        }
        $endMonthCol = $colIndex - 1;
        $sheet->mergeCellsByColumnAndRow($startMonthCol, 1, $endMonthCol, 1);
    }

    // Merge kategori yang sama
    foreach ($this->categoryMerge as $merge) {
        $sheet->mergeCells("{$merge['col']}{$merge['from']}:{$merge['col']}{$merge['to']}");
        $sheet->getStyle("{$merge['col']}{$merge['from']}:{$merge['col']}{$merge['to']}")
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
}


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Freeze header
                $event->sheet->freezePane('C4');
            },
        ];
    }
}
