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

        return[
            'message' => 'Location Uploaded'
        ];
    }

    public function show($id){
        $location = Location::find($id)->first;

        return [
            'message' => $location
        ];
    }
}