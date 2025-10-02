<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;

class PlanController extends Controller
{
    public function index(){
        $plans = Plan::all();
        return $this->responseJson(true,'Plans retrive successfull',[
            'data'=>PlanResource::collection($plans)
        ]);

    }
}
