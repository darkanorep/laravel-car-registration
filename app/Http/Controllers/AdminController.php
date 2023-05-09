<?php

namespace App\Http\Controllers;

use App\Exceptions\CarRegistrationException;
use App\Models\User;
use App\Models\Owner;
use App\Models\CarModel;
use App\Models\PlateNumber;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return User::with('carModels')->with('plateNumbers')->get();
    // }

    public function index(Request $request)
    {   
        // $cars = User::with(['carModels', 'carModels.plateNumbers'])->get();
        return User::with(['owners','owners.car', 'owners.plateNumber'])->paginate($request->row);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        } else {
            throw CarRegistrationException::userNotFound($id);
        }

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function restore($id) {
        
        $user = User::withTrashed()->find($id);

        if ($user) {

            $user = User::where('id', $id);
            
            if ($user) {
                $user->restore();
            }

            else {
                throw CarRegistrationException::userNotFound($id);
            }
        } else {
            throw CarRegistrationException::userNotFound($id);
        }

        return response()->json([
            'message' => 'User restored successfully'
        ]);
    }
}
