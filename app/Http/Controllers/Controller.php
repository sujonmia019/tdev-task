<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function responseJson($status='success',$message=null,$data=null,$response_code=200)
    {
        return response()->json([
            'status'        => $status,
            'message'       => $message,
            'data'          => $data,
            'response_code' => $response_code
        ]);
    }
}
