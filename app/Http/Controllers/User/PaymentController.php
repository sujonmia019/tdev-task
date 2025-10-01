<?php

namespace App\Http\Controllers\User;

use App\Models\Plan;
use App\Constants\Enum;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class PaymentController extends Controller
{
    public function pay(int $id)
    {
        $plan = Plan::findOrFail($id);
        $gateway = PaymentGateway::where('is_default', true)->firstOrFail();
        return match($gateway->name){
            'stripe'=>$this->redirectToStripe($plan,$gateway),
            'paypal'=>$this->redirectToPaypal($plan,$gateway),
            default=>back()->with('error','Invalid gateway'),
        };
    }

    protected function redirectToStripe(Plan $plan, PaymentGateway $gateway)
    {
        $response = Http::withHeaders([
            'Authorization'=>'Bearer '.$gateway->secret_key,
            'Content-Type'=>'application/x-www-form-urlencoded',
        ])->asForm()->post('https://api.stripe.com/v1/checkout/sessions',[
            'payment_method_types[]'                        => 'card',
            'line_items[0][price_data][currency]'           => $plan->currency,
            'line_items[0][price_data][unit_amount]'        => $plan->price*100,
            'line_items[0][price_data][product_data][name]' => $plan->name,
            'line_items[0][quantity]'                       => 1,
            'mode'                                          => 'payment',
            'success_url'                                   => route('user.payment.success',['plan_id'=>$plan->id,'gateway'=>$gateway->name]),
            'cancel_url'                                    => route('user.payment.cancel',['plan_id'=>$plan->id,'gateway'=>$gateway->name])
        ]);

        $session = $response->json();
        return isset($session['url']) ? redirect($session['url']) : back()->with('error',$session['error']['message']??'Stripe error');
    }

    protected function redirectToPaypal(Plan $plan, PaymentGateway $gateway)
    {
        $response = Http::withBasicAuth($gateway->public_key, $gateway->secret_key)
            ->asForm()
            ->post('https://api.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        $accessToken = $response->json()['access_token'] ?? null;

        if(!$accessToken) {
            return back()->with('error','PayPal token error');
        }

        // 2. Create order
        $orderResponse = Http::withToken($accessToken)
            ->post('https://api.sandbox.paypal.com/v2/checkout/orders', [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => $plan->currency,
                        'value' => $plan->price
                    ],
                    'description' => $plan->name
                ]],
                'application_context' => [
                    'return_url' => route('user.payment.success',['plan_id'=>$plan->id,'gateway'=>$gateway->name]),
                    'cancel_url' => route('user.payment.cancel',['plan_id'=>$plan->id,'gateway'=>$gateway->name])
                ]
            ]);

        $order = $orderResponse->json();

        if(!isset($order['links'])) {
            return back()->with('error','PayPal order creation failed');
        }

        // 3. Redirect to approval URL
        $approvalUrl = collect($order['links'])->firstWhere('rel', 'approve')['href'] ?? null;

        return $approvalUrl ? redirect($approvalUrl) : back()->with('error','PayPal approval URL not found');
    }


    public function success(Request $request)
    {
        $user = auth()->user();
        $plan = Plan::findOrFail($request->query('plan_id'));
        $gateway = $request->query('gateway');

        $subscription = Subscription::create([
            'user_id'    => $user->id,
            'plan_id'    => $plan->id,
            'start_date' => now(),
            'end_date'   => now()->addDays($plan->duration)
        ]);

        Payment::create([
            'user_id'         => $user->id,
            'subscription_id' => $subscription->id,
            'payment_gateway' => $gateway,
            'amount'          => $plan->price,
            'currency'        => $plan->currency,
            'transaction_id'  => $request->query('txn_id')??null,
            'status'          => Enum::COMPLETE
        ]);

        return redirect()->route('user.dashboard')->with('success',"Subscription to '{$plan->name}' plan was successful! Your subscription is valid until ".dateFormat($subscription->end_date,'d-m-Y').".");
    }

    public function cancel(Request $request)
    {
        $user = auth()->user();
        Payment::create([
            'user_id'         => $user->id,
            'subscription_id' => null,
            'payment_gateway' => $request->query('gateway'),
            'amount'          => 0,
            'currency'        => 'USD',
            'transaction_id'  => null,
            'status'          => Enum::FAILED
        ]);

        return redirect()->route('user.dashboard')->with('error', 'Payment was failed or cancelled.');
    }
}
