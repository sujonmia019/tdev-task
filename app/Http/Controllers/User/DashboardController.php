<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function verifiedUser(){
        if(auth()->user()->email_verified_at) return redirect()->route('user.dashboard');

        return view('user_portal.verify');
    }

    public function dashboard(){
        $data['user'] = Auth::user();
        $data['subscriptions'] = $data['user']->subscriptions()->with('plan', 'payment')->latest('start_date')->get();
        return view('user_portal.dashboard', $data);
    }

    public function planList(){
        $data['plans'] = Plan::latest()->get();
        return view('user_portal.plan', $data);
    }
}
