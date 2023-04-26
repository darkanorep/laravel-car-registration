<?php

namespace App\Exports;

use App\Models\Car;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class CarsExport implements FromCollection
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Car::all();
    }

    // public function __construct(string $car_brand)
    // {
    //     $this->car_brand = $car_brand;
    // }

    // public function query() {
    //     return Car::query();
    // }

    // public function query() {
    //     return Car::query()->where('car_brand', $this->car_brand);
    // }

    // public function map($car): array {
    //     return [
    //         $car->id,
    //         $car->car_brand
    //     ];
    // }

}
