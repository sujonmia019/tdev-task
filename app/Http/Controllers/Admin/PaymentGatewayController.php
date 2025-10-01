<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\GatewayRequest;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $gateways = PaymentGateway::all();
        return view('gateway.index', compact('gateways'));
    }

    public function store(GatewayRequest $request)
    {
        $collection = collect($request->validated());
        $is_default = $request->filled('is_default');
        $collection = $collection->merge(compact('is_default'));
        $gateway    = PaymentGateway::updateOrCreate(['name'=>$request->name], $collection->all());
        if ($gateway->is_default) {
            $gateway->setAsDefault();
        }

        return redirect()->back()->with('success', 'Gateway added successfull.');
    }

    public function setDefault(int $id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        $gateway->setAsDefault();
        return redirect()->back()->with('success', 'Default gateway updated.');
    }
}
