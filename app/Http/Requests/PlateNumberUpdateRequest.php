<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlateNumberUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'plate_number' => ['required','string', 'min:6', 'unique:plate_numbers',  'max:6'],
        ];
    }
}
