<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'amount' => 'required|numeric|between:0,999999.99|regex:/^\d+(\.\d{1,2})?$/',
            'paid' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Gutschein Betrag darf nicht leer sein.',
            'amount.numeric' => 'Betrag muss eine Zahl sein. Bei Cent Beträgen muss ein Punkt verwendet werden: 29.90',
            'amount.between' => 'Dein Betrag ist zu hoch. Der Maximalbetrag ist 999.999,99€',
            'amount.regex' => 'Zu viele Stellen im Centbetrag'
        ];
    }
}
