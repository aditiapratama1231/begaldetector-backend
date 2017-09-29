<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController
{
    public function send_response_api($data, $message=''){
        $meta = [
            'message' => $message,
            'success' => true
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }

    public function send_error_api($data, $message=''){
        $meta = [
            'message' => $message,
            'success' => false
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }
}