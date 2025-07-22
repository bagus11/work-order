<?php

namespace App\Exports;

use App\Models\MonitoringOPX;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
class OPXPivotExport implements FromArray
{
    protected $data;
    protected $months;

    public function __construct($data, $months)
    {
        $this->data   = $data;
        $this->months = $months;
    }

    public function array(): array
    {
        $header = array_merge(['CATEGORY', 'ITEM LIST'], $this->months);
        $rows   = [$header];

        foreach ($this->data as $row) {
            $rows[] = array_merge(
                [$row['category'], $row['product']],
                array_map(fn($m) => $row[$m] ?? 0, $this->months)
            );
        }

        return $rows;
    }
}

