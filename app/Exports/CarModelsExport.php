<?php

namespace App\Exports;

use App\Models\CarModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

// class CarModelsExport implements FromCollection
class CarModelsExport implements FromQuery, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return CarModel::all();
    // }

    public function query() {
        return DB::table('car_models')->select('car_id', 'car_model', 'car_year')
        ->orderBy('created_at', 'desc');
    }

    public function headings(): array {
        return [
            'car_id', 'car_model', 'car_year'
        ];
    }

}
