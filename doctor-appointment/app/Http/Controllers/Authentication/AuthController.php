<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Mail\UserRegistered;
use App\Models\Doctor;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponse;
    public function register(RegisterRequest $request) {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]); 

        if(strtolower($request->role) === 'doctor') {
            Doctor::create([
                'user_id' => $user->id, 
                'specialization' => $request->specialization, 
                'bio' => $request->bio, 
                'clinic_address' => $request->clinic_address, 
                'start_time' => $request->start_time, 
                'end_time' => $request->end_time
            ]);
        }

        Mail::to($user->email)->send(new UserRegistered($user));
        return $this->ok('User Registered Successfully');       
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->validated()))
        {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return $this->ok('Logged In successfully', $user, $token);
        }

        return $this->error('Something went wrong.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('User logged out successfully');
    }
}
