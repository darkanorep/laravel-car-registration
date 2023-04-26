<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Imports\CarsImport;
use Illuminate\Http\Request;
use App\Http\Requests\CarRequest;
use App\Http\Resources\CarResources;
use Maatwebsite\Excel\Facades\Excel;
use App\Exceptions\CarModelException;
use App\Http\Requests\CarUpdateRequest;
use App\Exceptions\CarRegistrationException;
use App\Exports\CarsExport;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::with('car_model')->get();

        return response()->json([
            'message' => 'Cars retrieved successfully',
            'cars' => $cars
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
        $car = Car::create([
            'car_brand' => $request->car_brand
        ]);

        return response()->json([
            'message' => 'Car created successfully',
            'car' => $car
        ]);

        // return new CarResources(Car::create([
        //     'message' => 'Car created successfully',
        //     'car_brand' => $request->car_brand
        // ]));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $car = Car::find($id);
        
        // if (!$car){
        //     return response()->json([
        //         throw CarRegistrationException::carNotFound($id)
        //     ]);
        // }

        // return Car::with('car_model')->where('id', $id)->get();

        return Car::find($id) ? Car::where('id', $id)->with('car_model')->get() : throw CarRegistrationException::carNotFound($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarUpdateRequest $request, $id)
    {

        // $car = Car::find($id);

        // if (!$car){
        //     return response()->json([
        //         throw CarRegistrationException::carNotFound($id)
        //     ]);
        // } else {
        //     $car->update([
        //         'car_brand' => $request->car_brand
        //     ]);
        // }

        Car::find($id) ? new CarResources(Car::find($id)->update(['car_brand' => $request->car_brand])) : throw CarRegistrationException::carNotFound($id);
        
        return response()->json([
            'message' => 'Car updated successfully',
            'data' => Car::find($id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $car = Car::find($id);

        // if (!$car){
        //     return response()->json(
        //         throw CarRegistrationException::carNotFound($id)
        //     );
        // } else {
        //     $car->delete();
        // }

        // return response()->json([
        //     'message' => 'Car deleted successfully.'
        // ], 200);

        Car::find($id) ?  Car::find($id)->delete() : throw CarRegistrationException::carNotFound($id);
        return response()->json([
            'message' => 'Car deleted successfully.'
        ], 200);
    }

    public function restore($id) {
        $car = Car::find($id);

        if (!$car) {
            $car = Car::where('id', $id)->restore();

            return response()->json([
                'message' => 'Successfully restored.',
                'data' => Car::find($id)
            ]);

        } else {
            return response()->json(
                throw CarRegistrationException::carNotFound($id)
            );
        }
    }

// public function importForm() {
//     return response()->view('import-form');
// }


    public function import(Request $request) {
        Excel::import(new CarsImport,$request->file);

        // (new CarsImport)->import($request->file);
        return response()->json([
            'message' => 'Successfully imported.'
        ]);
    }

    public function export() {
        return Excel::download(new CarsExport, 'cars.csv');

        // (new CarsExport)->queue('cars.xlsx');

        // return back()->withSuccess('Export started!');
    }
}
