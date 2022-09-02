<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'prefix' => 'nullable|alpha|max:3',
            'logo' => 'nullable',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'prefix.alpha' => 'Prefix muss aus Buchstaben bestehen',
            'prefix.max' => 'Prefix darf maximal aus drei Buchstaben bestehen',
        ];
    }
}
