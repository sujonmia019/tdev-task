<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Enum;
use App\Models\User;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(){
        $totalUsers       = User::count();
        $activeSubs       = Subscription::where('end_date', '>=', now())->count();
        $totalRevenue     = Payment::where('status',Enum::COMPLETE)->sum('amount');
        $pendingPayments  = Payment::where('status',Enum::PENDING)->count();
        $cancelledPayments= Payment::where('status',Enum::FAILED)->count();
        $defaultGateway   = PaymentGateway::where('is_default', true)->first();

        $latestSubscriptions = Subscription::with(['user','plan','payment'])
                                            ->latest('start_date')
                                            ->take(5)
                                            ->get();

        $latestPayments = Payment::with(['user','subscription'])
                                 ->latest('created_at')
                                 ->take(5)
                                 ->get();

        return view('dashboard', compact(
            'totalUsers', 'activeSubs', 'totalRevenue', 'pendingPayments',
            'cancelledPayments','defaultGateway','latestSubscriptions','latestPayments'
        ));
    }
}
