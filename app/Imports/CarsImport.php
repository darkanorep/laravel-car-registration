<?php

namespace App\Imports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CarsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Car([
            'car_brand' => $row['car_brand']
        ]);
    }

    public function rules(): array {
        return [
            '*.car_brand' => ['string', 'min:3', 'unique:cars,car_brand']
        ];
    }
}
