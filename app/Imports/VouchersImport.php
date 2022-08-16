<?php

namespace App\Imports;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VouchersImport implements ToCollection, WithHeadingRow
{

    use Importable;

    public function __construct($userId)
    {
        $this->userId = $userId;

        return $this;
    }


    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $voucher = new Voucher();

            $voucher->user_id = $this->userId;
            $voucher->code = $row['gutschein_code'];
            $voucher->paid_on = $row['bezahlt_am'] ? Carbon::parse($row['bezahlt_am'])->toDateTimeString() : null;
            $voucher->cashed_on = $row['eingelost_am'] ? Carbon::parse($row['eingelost_am'])->toDateTimeString() : null;
            $voucher->save();

            $voucher->amountHistory()->create([
                'amount' => $row['gutschein_betrag']
            ]);

            if (is_numeric($row['restbetrag']) && $row['restbetrag'] !== $row['gutschein_betrag']) {
                // race conditions
                $initial = $voucher->amountHistory()->latest()->first();

                $initial->created_at = Carbon::parse($initial->created_at)->subHour()->toDateTimeString();
                $initial->save();

                $voucher->amountHistory()->create([
                    'amount' => $row['restbetrag']
                ]);
            }
        }
    }
}
