<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['access_token'] =  $user->createToken('access_token')->accessToken;
            return [
                'token' => $success,
                'meta' => [
                    'message' => "Log in Success",
                    'success' => true            
                ]
            ];
        }
        else{
            return [
                'error' => 'Unauthorised',
                'meta' => [
                    'success' => false
                ]
            ];
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return [
                'error' => $validator->errors(),
                'meta' => [
                    'message' => 'data required',
                    'success' => false
                ]
            ];          
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['access_token'] =  $user->createToken('access_token')->accessToken;
        $success['name'] =  $user->name; 
        return [
            'token' => $success,
            'meta' => [
                'message' => 'Register Success',
                'success' => true        
            ]
        ];
    }

    public function profile(){
        $user = Auth::user();
        return [
            'data' => $user
        ];
    }
}