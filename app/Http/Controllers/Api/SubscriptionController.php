<?php

namespace App\Http\Controllers\Api;

use App\Constants\Enum;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    /**
     * Redirects user to payment gateway URL (Stripe / PayPal)
     */
    public function pay(Request $request, int $plan_id)
    {
        $user = $request->user();
        $plan = Plan::findOrFail($plan_id);

        $gateway = PaymentGateway::where('is_default', true)->firstOrFail();

        return match($gateway->name) {
            'stripe' => $this->redirectToStripeApi($user, $plan, $gateway),
            'paypal' => $this->redirectToPaypalApi($user, $plan, $gateway),
            default  => $this->responseJson(false,'Invalid payment gateway', null, 422)
        };
    }

    /**
     * Stripe API Payment
     */
    protected function redirectToStripeApi($user, $plan, $gateway)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $gateway->secret_key,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://api.stripe.com/v1/checkout/sessions', [
            'payment_method_types[]'                        => 'card',
            'line_items[0][price_data][currency]'           => $plan->currency,
            'line_items[0][price_data][unit_amount]'        => $plan->price * 100,
            'line_items[0][price_data][product_data][name]' => $plan->name,
            'line_items[0][quantity]'                       => 1,
            'mode'                                          => 'payment',
            'success_url'                                   => route('api.payment.success',['plan_id'=>$plan->id,'gateway'=>$gateway->name]),
            'cancel_url'                                    => route('api.payment.cancel',['gateway'=>$gateway->name])
        ]);

        $session = $response->json();

        return isset($session['url'])
            ? $this->responseJson(true,'Redirect to Stripe checkout',[
                'url' => $session['url']
            ])
            : $this->responseJson(false,$session['error']['message'] ?? 'Stripe error', null, 500);
    }

    /**
     * PayPal API Payment
     */
    protected function redirectToPaypalApi($user, $plan, $gateway)
    {
        $response = Http::withBasicAuth($gateway->public_key, $gateway->secret_key)
            ->asForm()
            ->post('https://api.sandbox.paypal.com/v1/oauth2/token', [
                'grant_type' => 'client_credentials'
            ]);

        $accessToken = $response->json()['access_token'] ?? null;
        if(!$accessToken){
            return $this->responseJson(false,'PayPal token error', null, 500);
        }

        // Create Order
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
                    'return_url' => route('api.payment.success',['plan_id'=>$plan->id,'gateway'=>$gateway->name]),
                    'cancel_url' => route('api.payment.cancel',['gateway'=>$gateway->name])
                ]
            ]);

        $order = $orderResponse->json();
        $approvalUrl = collect($order['links'] ?? [])->firstWhere('rel','approve')['href'] ?? null;

        return $approvalUrl
            ? $this->responseJson(true,'Redirect to PayPal checkout',[
                'url' => $approvalUrl
            ])
            : $this->responseJson(false,'PayPal order creation failed', null, 500);
    }

    /**
     * Payment Success API
     */
    public function success(Request $request)
    {
        $user = $request->user();
        $plan = Plan::findOrFail($request->query('plan_id'));
        $gateway = $request->query('gateway');

        $subscription = Subscription::create([
            'user_id'    => $user->id,
            'plan_id'    => $plan->id,
            'start_date' => now(),
            'end_date'   => now()->addDays($plan->duration),
            'status'     => 'active'
        ]);

        // Record payment
        Payment::create([
            'user_id'         => $user->id,
            'subscription_id' => $subscription->id,
            'payment_gateway' => $gateway,
            'amount'          => $plan->price,
            'currency'        => $plan->currency,
            'transaction_id'  => $request->query('txn_id') ?? null,
            'status'          => Enum::COMPLETE
        ]);

        return $this->responseJson(true,"Subscription to '{$plan->name}' plan was successful!",[
            'subscription' => $subscription
        ]);
    }

    /**
     * Payment Cancel API
     */
    public function cancel(Request $request)
    {
        $user = $request->user();

        Payment::create([
            'user_id'         => $user->id,
            'subscription_id' => null,
            'payment_gateway' => $request->query('gateway'),
            'amount'          => 0,
            'currency'        => 'USD',
            'transaction_id'  => null,
            'status'          => Enum::FAILED
        ]);

        return $this->responseJson(false,'Payment was cancelled or failed', null, 400);
    }
}
