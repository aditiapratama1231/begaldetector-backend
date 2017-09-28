<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Location;
use Illuminate\Support\Facades\Auth;
use Validator;

class LocationController extends Controller
{
    public function index(){
        $locations = Location::all();

        return [
            'data' => $locations,
            'meta' => [
                'message' => 'data retrieved sucessfully',
                'success' => true
            ]
        ];
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);

        if($validator->fails()){
            return [
                'error' => $validator->error(),
                'meta' => [
                    'message' => 'data required',
                    'success' => true
                ]
            ];
        }

        $data = array(
            'user_id' => Auth::user()->id,
            'city' => $request->city,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'information' => $request->information
        );
        $location = Location::create($data);

        if($location){
            return[
                'data' => $data,
                'meta' => [
                    'success' => true,
                    'message' => 'Location Uploaded'             
                ]
            ];
        }else{
            return [
                'data' => $data,
                'meta' => [
                    'message' => 'Upload Location Failed',
                    'success' => true
                ]
            ];
        }
    }

    public function show($id){
        $location = Location::find($id);
        $user = $location->User;
        if($location){
            return [
                'data' => $location,
                'meta' => [
                    'message' => 'data retrieved successfully',
                    'success' => true
                ]
            ];    
        }else{
            return [
                'data' => null,
                'meta' => [
                    'message' => 'data not found',
                    'success' => false
                ]
            ];
        }
        
    }

    public function delete($id){
        $location = Location::find($id);
        $user = $location->User;
        if($user['id'] == Auth::User()->id){
            $location = Location::find($id)->first()->delete();
            if($location){
                return [
                    'data' => $location,
                    'meta' => [
                        'message' => 'data deleted',
                        'success' => true                        
                    ]
                ];
            }else{
                return[
                    'data' => $location,
                    'meta' => [
                        'message' => 'data not deleted',
                        'success' => false
                    ]
                ];
            }
        }else{
            return [
                'data' => $location,
                'meta' => [
                    'message' => 'You cannot delete this location',
                    'success' => false
                ]
            ];
        }
    }
}