<?php

namespace App\Exports;

use App\Models\Voucher;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VouchersExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithStyles
{
    use Exportable;

    public function __construct($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function query(): Relation|EloquentBuilder|Builder
    {
        return Voucher::query()->where('user_id', '=', $this->userId)->with('amountHistory');
    }

    /**
     * @throws Exception
     */
    public function map($row): array
    {
        return [
            $row->code,
            $row->getInitialAmount(),
            $row->getActualAmount(),
            $row->paid_on,
            $row->cashed_on,
        ];
    }

    public function headings(): array
    {
        return [
            'Gutschein Code',
            'Gutschein Betrag',
            'Restbetrag',
            'Bezahlt am',
            'Eingelöst am'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]]
        ];
    }
}
