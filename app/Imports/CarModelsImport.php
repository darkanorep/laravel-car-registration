<?php

namespace App\Imports;

use App\Models\CarModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CarModelsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row) {
        return new CarModel([
            'car_id' => $row['car_id'],
            'car_model' => $row['car_model'],
            'car_year' => $row['car_year'],
            'top_speed' => $row['top_speed']
        ]);
    }

    public function rules(): array {
        return [
            '*.car_id' => ['required', 'integer', 'exists:cars,id',],
            '*.car_model' => ['required', 'string', 'unique:car_models,car_model',],
            '*.car_year' => ['required', 'integer', 'min:1950', 'max:2050'],
            '*.top_speed' => ['integer', 'min:0']
        ];
    }
}
