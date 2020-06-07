<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(RegisterRequest $request){

        $user = User::create([
            'name'=>$request->name ,
            'email'=>$request->email ,
            'password' => Hash::make($request->password)
        ]) ;

        if(! $token = auth()->attempt($request->only(['email','password']))){

            return abort(401);
        }

        return (new UserResource($user))->additional([
            'meta'=>[
                'token'=>$token
            ]
        ]) ;
    }


    public function login(LoginRequest $request){

        if(! $token = auth()->attempt($request->only(['email','password']))){

            return \response()->json([
                'errors'=>[
                    'email'=>'we can not find your email'
                ]
            ],401);
        }

        return (new UserResource($request->user()))->additional([
            'meta'=>[
                'token'=>$token
            ]
        ]) ;

    }

    public function user(Request $request){

        return new UserResource($request->user()) ;
    }


    public function logout(){
         \auth()->logout();

    }
}
