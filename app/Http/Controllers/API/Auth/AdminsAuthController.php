<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function App\Helpers\response_json;

class AdminsAuthController extends Controller{
    public function __construct(){
        auth()->shouldUse('admin-api');
        $this->middleware('auth:admin-api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return response_json([
                'ok'=>false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $admin = Auth::user();
        return response_json([
            'ok'=>true,
            'admin_id' => $admin->id,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response_json([
            'ok'=>true,
            'message' => 'admin created successfully',
            'user' => $admin
        ]);
    }

    public function logout(){
        Auth::logout();
        return response_json([
            'ok'=>true,
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh(){
        return response_json([
            'ok'=>true,
            'user' => Auth::admin(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
