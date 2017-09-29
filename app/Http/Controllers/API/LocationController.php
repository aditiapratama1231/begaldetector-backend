<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Location;
use App\Http\Controllers\API\BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;

class LocationController extends Controller
{
    protected $baseController;
    public function __construct(BaseController $baseController){
        $this->baseController = $baseController;
    }

    public function index(){
        $data = Location::all();
        return $this->baseController->send_response_api($data, "Data retrieved success");
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required'
        ]);

        if($validator->fails()){
            return $this->baseController->send_error_api($validator->error(), 'Data required');
        }

        $data = array(
            'user_id' => Auth::user()->id,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'information' => $request->information
        );
        $location = Location::create($data);

        if($location){
            return $this->baseController->send_response_api($data, 'Location uploaded');
        }else{
            return $this->baseController->send_error_api($data, 'Upload location failed');
        }
    }

    public function show($id){
        $data = Location::find($id);
        if($data){
            return $this->baseController->send_response_api($data, 'Data retrieved successfully');
        }else{
            return $this->baseController->send_error_api($data, 'Data not found');
        }
    }

    public function delete($id){
        $location = Location::find($id);
        $user = $location->User;
        if($user['id'] == Auth::User()->id){
            $data = $location->delete();
            if($data){
                return $this->baseController->send_response_api(null, 'Data deleted');
            }else{
                return $this->baseController->send_error_api($data, 'Data not deleted');
            }
        }else{
            return $this->baseController->send_error_api($data, 'You cannot delete this location');
        }
    }
}