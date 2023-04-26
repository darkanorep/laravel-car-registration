<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CarRegistrationException;
use App\Http\Requests\ChangePasswordRequest;

class AuthController extends Controller
{
    public function register(UserRequest $request) {

        return response()->json([
            'message' => 'Successful registered',
            new UserResource(User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->has('role') ? $request->role : 'user',
                'address' => $request->address,
                'dob' => Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d'),
                'age' => Carbon::parse($request->dob)->age,
                'gender' => $request->gender
            ]))
        ]);
    }

    public function login(Request $request) {

        if (auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login successful',
                'user' => auth()->user()->name,
                'token' => auth()->user()->createToken('authToken of '.auth()->user()->name)->plainTextToken]
            );
        } else {
            return response()->json(throw CarRegistrationException::authError());
        }

    }

    public function logout() {

        Auth::user()->tokens()->delete();
        
        return response()->json([
            'message' => 'Logout successful'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request) {
        
        User::find(Auth::user()->update([
            'password' => bcrypt($request->password)
        ]));
        
        return response()->json([
            'message' => 'Successfully changed password.'
        ]);
    }
}
