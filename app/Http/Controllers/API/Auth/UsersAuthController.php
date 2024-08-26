<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function App\Helpers\response_json;

class UsersAuthController extends Controller{

    public function __construct(){
        \auth()->shouldUse('user-api');
        $this->middleware('auth:user-api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response_json([
                'ok'=>false,
                'message' => 'Unauthorized (email or password is wrong)',
            ], 401);
        }

        $user = Auth::user();
        return response_json([
            'ok'=>true,
            'user_id' => $user->id,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response_json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout(){
        Auth::logout();
        return response_json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh(){
        return response_json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
