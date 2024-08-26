<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\response_json;

class Authenticate extends Middleware{

    protected function redirectTo(Request $request){
        return $request->expectsJson() ? null : route('user-login');
    }

    protected function unauthenticated($request, array $guards){

        if(!auth('custom-header')->check()){
            abort(response_json(['ok'=>false,'message' => "unauthenticated header."], 401));
        }
        if ($request->route()->middleware()[0] === 'api'){
            abort(response_json(['ok'=>false,'message' => "unauthenticated user."], 401));
        }
        parent::unauthenticated($request, $guards);
    }
}
