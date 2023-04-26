<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\PlateNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PlateNumberRequest;
use App\Exceptions\CarRegistrationException;
use App\Http\Requests\PlateNumberUpdateRequest;

class PlateNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlateNumberRequest $request) {

        $owner_id = $request->owner_id;
        $owner = Owner::where('user_id', Auth::user()->id)->find($owner_id);

        return $owner ? response()->json([PlateNumber::create([
            'owner_id' => $owner_id,
            'plate_number' => $request->plate_number])
        ]) : throw new CarRegistrationException("You don't have a car with id $owner_id.", 404);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlateNumberUpdateRequest $request, string $id)
    {
        $owner = Auth::user()->id;
        $plate_number = PlateNumber::with('plateNumber')->find($id);
        

        if (!$plate_number) {

            throw new CarRegistrationException("Plate number with id $id not found.", 404);
            
        } else {

            $user_id = $plate_number->plateNumber->user_id;

            if ($user_id != $owner) {
                throw new CarRegistrationException("Plate number with id $id not found.", 404);
            } else {
                $plate_number->update([
                    'plate_number' => $request->plate_number
                ]);
    
                return response()->json([
                    'message' => 'Plate number updated successfully.',
                    'data' => $plate_number
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
