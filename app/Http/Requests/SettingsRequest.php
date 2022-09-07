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
            'name' => 'nullable|string|max:100',
            'logo' => 'nullable|mimes:jpg,png|dimensions:max_width=5000,max_height:5000|max:1024',
            'text' => 'nullable|string|max:255'
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
            'logo.dimensions' => 'Logo darf maximal 5000px x 5000px haben',
            'logo.max' => 'Logo darf nicht mehr als 1MB groß sein',
            'logo.mimes' => 'Logo muss vom Typ: jpg oder png sein',
            'name.string' => 'Name muss ein Text sein',
            'name.max' => 'Name zu lang',
            'text.max' => 'Dein Text darf aus maximal 255 Zeichen bestehen',
            'text.string' => 'Dein Text muss ein Text sein'
        ];
    }
}
