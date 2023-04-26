<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Http\Requests\OwnerRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserCarRequest;
use App\Exceptions\CarRegistrationException;
use App\Http\Requests\PlateNumberRequest;
use App\Http\Resources\OwnerResource;
use App\Models\PlateNumber;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = Owner::with('car')->with('plateNumber')->where('user_id', Auth::user()->id)->get();
        return OwnerResource::collection($owners);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerRequest $request)
    {
        $car = Owner::create([
            'user_id' => Auth::user()->id,
            'car_model_id' => $request->car_model_id
        ]);

        // return response()->json([
        //     'message' => 'Car added.',
        //     'data' => $car
        // ]);

        return new OwnerResource($car);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = Owner::with('car')->with('plateNumber')->where('user_id', Auth::user()->id)->where('id', $id)->first();

        return $car ? new OwnerResource($car) : throw CarRegistrationException::carModelNotFound($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserCarRequest $request, $id)
    {   
        $car = Owner::where('user_id', Auth::user()->id)->where('id', $id)->first();
            
        $car ? $car->update([
            'car_model_id' => $request->car_model_id
        ]) : throw CarRegistrationException::carModelNotFound($id);

        // return response()->json([
        //     'message' => 'Car updated.'
        // ]);

        return new OwnerResource($car);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car = Owner::where('user_id', Auth::user()->id)->find($id);

        $car ? $car->delete() : throw new CarRegistrationException("Car not found by id: $id or already deleted.", 404);
        return response()->json(['message' => 'Car deleted.']);
    }
    

    public function restore($id) {
        $car = Owner::where('user_id', Auth::user()->id)->withTrashed();
    
        if($car) {
            $carValidate = Owner::find($id);
            if ($carValidate) {
                throw new CarRegistrationException("Car not found by id: $id or already restored.", 404);
            } else {
                $car->restore();
                return response()->json([
                    'message' => 'Car restored.'
                ], 200);
            }
        }
    }

    // public function registerPlateNumber(PlateNumberRequest $request) {

    //     $owner_id = $request->owner_id;
    //     $owner = Owner::where('user_id', Auth::user()->id)->find($owner_id);

    //     return $owner ? response()->json([PlateNumber::create([
    //         'owner_id' => $owner_id,
    //         'plate_number' => $request->plate_number])
    //     ]) : throw new CarRegistrationException("You don't have a car with id $owner_id.", 404);
        
    // }
    
}
