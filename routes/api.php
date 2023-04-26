<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\PlateNumberController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', AuthController::class . '@register');
Route::post('/login', AuthController::class . '@login');

Route::group(['middleware' => ['auth:sanctum']], function () {

    //user end
    Route::group(['prefix' => '/'], function () {
       Route::resource('/my-cars', UserController::class);
       Route::post('/my-cars/{id}', UserController::class . '@restore');
       Route::post('/change-password', AuthController::class . '@changePassword');
       Route::resource('/car-register', PlateNumberController::class);
    });
    
    //admin end
    Route::group(['prefix' => '/', 'middleware' => ['auth' => 'admin']], function () {

        //Car
        Route::resource('/cars', CarController::class);
        Route::post('/cars/{id}', CarController::class . '@restore');

        //Import and export Car
        Route::post('/import', CarController::class . '@import');
        Route::get('/export', CarController::class . '@export');
        

        //Car Model
        Route::resource('/models', CarModelController::class);
        Route::post('/models/{id}', CarModelController::class . '@restore');

        //User
        Route::resource('/users', AdminController::class);
    
    });

    //global logout
    Route::post('/logout', AuthController::class . '@logout');

});

