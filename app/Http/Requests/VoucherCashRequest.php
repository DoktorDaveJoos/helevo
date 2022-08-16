<?php

namespace App\Http\Requests;

use App\Models\Voucher;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class VoucherCashRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount' => 'numeric|between:0.01,999999.99|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'amount.numeric' => 'Betrag muss eine Zahl sein. Bei Cent Beträgen muss ein Punkt verwendet werden: 29.90',
            'amount.between' => 'Dein Betrag ist zu hoch oder zu niedrig. Mögliche Beträge zwischen 0,01 bis 999.999,99€',
            'amount.regex' => 'Zu viele Stellen im Centbetrag'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $voucher = Voucher::find($this->route('id'));

            if ($voucher->getActualAmount() < $validator->validated()['amount']) {
                $validator->errors()->add('amount', 'Betrag zu hoch. Maximal Betrag: ' . $voucher->getActualAmount());
            }
        });
    }


}
