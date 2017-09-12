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
            'data' => $locations
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
                'error' => $validator->error()
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
                 'message' => 'Location Uploaded'
            ];
        }else{
            return [
                'message' => 'Upload Location Failed'
            ];
        }
    }

    public function show($id){
        $location = Location::find($id);
        $user = $location->User;

        return [
            'data' => $location
        ];
    }

    public function delete($id){
        $location = Location::find($id);
        $user = $location->User;
        if($user['id'] == Auth::User()->id){
            $location = Location::find($id)->first()->delete();
            if($location){
                return [
                    'message' => 'Success'
                ];
            }else{
                return[
                    'message' => 'Failed'
                ];
            }
        }else{
            return [
                'message' => 'You cannot delete this location'
            ];
        }
    }
}