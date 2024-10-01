<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

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
