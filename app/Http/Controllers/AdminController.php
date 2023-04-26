<?php

namespace App\Http\Controllers;

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

    public function index()
    {   
       

        // $cars = User::with(['carModels', 'carModels.plateNumbers'])->get();
        $cars = User::with(['owners','owners.car', 'owners.plateNumber'])->get();
        return $cars;

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
    public function destroy(string $id)
    {
        //
    }
}
