<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'plan', 'payment'])
                            ->latest('start_date')
                            ->paginate(00);

        return view('subscription.index', compact('subscriptions'));
    }
}
