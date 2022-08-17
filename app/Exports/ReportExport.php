<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct(int $userId, string $month, string $year)
    {
        $this->userId = $userId;
        $this->month = $month;
        $this->year = $year;

        return $this;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ReportVouchersSoldSheet($this->userId, $this->year, $this->month);
        $sheets[] = new ReportVouchersCashedSheet($this->userId, $this->year, $this->month);
        return $sheets;
    }
}
