<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OPXExport implements WithMultipleSheets
{
    protected $pivotData;
    protected $amountSourceData;
    protected $months;
    protected $locations;

    public function __construct($pivotData, $amountSourceData, $months, $locations)
    {
        $this->pivotData        = $pivotData;
        $this->amountSourceData = $amountSourceData;
        $this->months           = $months;
        $this->locations        = $locations;
    }

    public function sheets(): array
    {
        return [
            'Pivot Summary' => new OPXPivotExport(
                $this->pivotData,
                $this->months,
                $this->locations
            ),
          'Amount Source' => new AmountSourceExport(
                array_keys($this->pivotData),
                $this->amountSourceData,
                $this->months,
                $this->locations
            ),

        ];
    }
}
