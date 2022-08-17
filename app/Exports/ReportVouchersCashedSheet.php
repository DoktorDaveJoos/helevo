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

class ReportVouchersCashedSheet implements FromQuery, WithTitle, WithMapping, WithHeadings, WithStyles, ShouldAutoSize, WithColumnFormatting
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
            ->whereHas('amountHistory', function (Builder $query) {
                $query->whereYear('created_at', $this->year)
                    ->whereMonth('created_at', $this->month);
            });
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return sprintf('Gutschein Einlösungen %s-%s', $this->month, $this->year);
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
                $this->getCashedAmount($row),
            ];
        }
    }

    public function prepareRows($rows)
    {
        $sum = 0;

        foreach ($rows as $row) {
            $sum += $this->getCashedAmount($row);
        }

        $rows[] = [
            'is_summary' => true,
            'summary' => $sum,
        ];

        return $rows;
    }

    private function getCashedAmount($row) {
        $voucher = Voucher::find($row->id);

        $amountMin = $voucher->amountHistory()->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)->min('amount');

        $amountMax = $voucher->amountHistory()->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)->max('amount');

        $amountBefore = null;

        if ($amountMax === $voucher->initial_amount) {
            $amountBefore = $voucher->initial_amount;
        } else {
            $amountBefore = $voucher->amountHistory()
                ->whereBetween('amount', [$amountMax, $voucher->initial_amount])
                ->max('amount');
        }

        return $amountBefore - $amountMin;
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
