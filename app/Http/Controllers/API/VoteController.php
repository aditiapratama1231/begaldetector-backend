<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController;
use App\User;
use App\Vote;
use Illuminate\Support\Facades\Auth;
use Validator;

class VoteController extends Controller
{
    protected $baseController;
    public function __construct(BaseController $baseController){
        $this->baseController = $baseController;
    }
    public function create(Request $request){
        $data = array(
            'user_id' => Auth::user()->id,
            'location_id' => $request->location_id,
            'vote' => 'up'
        );

        $max_vote =  Vote::where('user_id', '=', Auth::user()->id)
                            ->where('location_id', '=', $request->location_id)->count();
    
        if($max_vote != 0){
            return $this->baseController->send_error_api(null, 'You already vote this location');
        }

        $vote = Vote::create($data);

        if($vote){
            return $this->baseController->send_response_api($data, 'Vote success');
        }else{
            return $this->baseController->send_error_api($data, 'Vote failed');
        }
    }

    public function get($location_id){
        $data = Vote::where('location_id', '=', $location_id)->count();

        if($data != null){
            return $this->baseController->send_response_api($data, 'Data retrieved successfully');
        }else{
            return $this->baseController->send_error_api($data, 'Data not found');
        }
    }
}