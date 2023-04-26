<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarModelRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [            
            'car_id' => ['required', 'integer', 'exists:cars,id'],
            'car_model' => ['required', 'string', 'max:255',  'unique:car_models,car_model'],
            'car_year' => ['required', 'integer']
        ];
    }
}
