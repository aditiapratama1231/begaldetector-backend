<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Vote;
use Illuminate\Support\Facades\Auth;
use Validator;

class VoteController extends Controller
{
    public function create(Request $request){
        $data = array(
            'user_id' => Auth::user()->id,
            'location_id' => $request->location_id,
            'vote' => 'up'
        );

        $max_vote =  Vote::where('user_id', '=', Auth::user()->id)
                            ->where('location_id', '=', $request->location_id)->count();
    
        if($max_vote != 0){
            return [
                'meta' => [
                    'message' => 'You already vote this',
                    'success' => false
                ]
            ];
        }

        $vote = Vote::create($data);

        if($vote){
            return [
                'data' => $data,
                'meta' => [
                    'message' => 'Vote success',
                    'success' => true
                ]
            ];
        }else{
            return [
                'data' => $data,
                'meta' => [
                    'message' => 'Vote failed',
                    'success' => false                
                ]
            ];
        }
    }

    public function get($location_id){
        $vote = Vote::where('location_id', '=', $location_id)->count();

        if($vote != null){
            return [
                'data' => $vote,
                'meta' => [
                    'message' => 'data retrieved successfully',
                    'success' => true
                ]
            ];
        }else{
            return [
                'data' => 0,
                'meta' => [
                    'message' => 'data not found',
                    'success' => false
                ]
            ];
        }
    }
}