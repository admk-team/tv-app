<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Stripe\Stripe;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey($request->stripeSecret);
        $stripeAmount = round(session('MONETIZATION')['AMOUNT'] * 100, 2);

        try {
            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price_data' => [
                        'product_data' => [
                            'name' => session('MONETIZATION')['PAYMENT_INFORMATION'],
                            'metadata' => [
                                'pro_id' => session('MONETIZATION')['MONETIZATION_GUID']
                            ]
                        ],
                        'unit_amount' => $stripeAmount,
                        'currency' => 'USD',
                    ],
                    'quantity' => 1
                ]],
                'mode' => 'payment',
                'success_url' => url('/stripe/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/monetization/cancel'),
            ]);
        } catch (Exception $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $checkout_session) {
            return response()->json([
                'status' => 1,
                'message' => 'Checkout Session created successfully!',
                'sessionId' => $checkout_session->id
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'error' => array(
                    'message' => 'Checkout Session creation failed! ' . $api_error
                )
            ]);
        }
    }

    public function success(Request $request)
    {
        try {
            // $session_id = $request->query('session_id');
            // $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
            // $paymentIntent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
            // $customer_details = $checkout_session->customer_details; 
            // $transactionID = $paymentIntent->id;
            // $paidAmount = $paymentIntent->amount / 100;
            // $paidCurrency = $paymentIntent->currency;
            // $payment_status = $paymentIntent->status;

            return redirect('/monetization/success');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

}