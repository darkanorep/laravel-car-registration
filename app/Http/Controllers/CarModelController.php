<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Http\Request;
use App\Imports\CarModelsImport;
use App\Http\Resources\CarResources;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CarModelRequest;
use App\Exceptions\CarRegistrationException;
use App\Exports\CarModelsExport;
use App\Http\Requests\CarModelUpdateRequest;

class CarModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CarModel::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarModelRequest $request)
    {   
        $car_id = $request->car_id;

        return Car::find($car_id) ? new CarResources(CarModel::create([
            'car_id' => $request->car_id,
            'car_model' => $request->car_model,
            'car_year' => $request->car_year
        ])) : throw CarRegistrationException::carNotFound($car_id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return !CarModel::find($id) ? throw CarRegistrationException::carModelNotFound($id) : new CarResources(CarModel::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarModelUpdateRequest $request, $id)
    {
        $model = CarModel::find($id);

        !$model ? throw CarRegistrationException::carModelNotFound($id) : $model->update([
            'car_model' => $request->car_model,
            'car_year' => $request->car_year
        ]);

        return response()->json([
            'message' => 'Successfully updated',
            new CarResources($model)
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        CarModel::find($id) ? CarModel::find($id)->delete() : throw CarRegistrationException::carModelNotFound($id);
        
        return response()->json([
            'message' => 'Successfully deleted.'
        ]);
    }

    public function restore($id) {

        $model = CarModel::find($id);

        if (!$model) {
            $car_id = CarModel::where('id', $id)->restore();

            if (!$car_id) {
                throw CarRegistrationException::carModelNotFound(null);
            }

            return response()->json([
                'message' => 'Successfully restored'
            ]);

        } else {
            throw CarRegistrationException::carModelNotFound($id);
        }
    }

    public function import(Request $request) {
        Excel::import(new CarModelsImport, $request->file);

        return response()->json([
            'message' => 'Successfully Car Models imported.'
        ]);
    }

    public function export() {
        return (new CarModelsExport)->download('car_models.xlsx');
    }
}
