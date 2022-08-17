<?php

namespace App\Exports;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportVouchersSoldSheet implements FromQuery, WithTitle, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    private $userId;
    private $month;
    private $year;

    public function __construct(int $userId, string $year, string $month)
    {
        $this->userId = $userId;
        $this->month = Carbon::parse($month)->month;
        $this->year = Carbon::parse($year)->year;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Voucher::query()
            ->where('user_id', '=', $this->userId)
            ->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return sprintf('Gutschein Einnahmen %s-%s', $this->month, $this->year);
    }

    public function map($row): array
    {
        if (isset($row['is_summary']) && $row['is_summary'] === true) {
            //Return a summary row
            return [
                'Total:',
                $row['summary'],
            ];
        } else {
            //Return a normal data row
            return [
                $row->code,
                $row->initial_amount,
            ];
        }
    }

    public function prepareRows($rows)
    {
        $sum = 0;

        foreach ($rows as $row) $sum += $row->initial_amount;

        $rows[] = [
            'is_summary' => true,
            'summary' => $sum,
        ];

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Gutschein Code',
            'Gutschein Betrag',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_CURRENCY_EUR,
        ];
    }
}
