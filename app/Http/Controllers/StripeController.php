<?php

namespace App\Http\Controllers;

use \Stripe\Stripe;
use App\Services\Api;
use App\Services\AppConfig;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey($request->stripeSecret);
        if ($request->has('amount')) {
            session()->put('MONETIZATION.AMOUNT', $request->amount);
        }
        $stripeAmount = round(session('MONETIZATION')['AMOUNT'] * 100, 2);
        $stripeProductId = null;
        $plan = null;
        if (isset(session('MONETIZATION')['stripe_product_id']) && !empty(session('MONETIZATION')['stripe_product_id'])) {
            $stripeProductId = session('MONETIZATION')['stripe_product_id'];
        }

        if ($stripeProductId) {
            $sPlans = AppConfig::get()->app->s_plan;

            // Filter the plan
            $matchingPlan = array_filter($sPlans, function ($plan) use ($stripeProductId) {
                return isset($plan->stripe_product_id) && $plan->stripe_product_id === $stripeProductId;
            });

            // Get the first matching plan (if necessary)
            $plan = reset($matchingPlan); // This retrieves the first element
        }


        if ($plan && $plan->stripe_product_trail) {
            $subscriptionData = [
                'trial_period_days' => $plan->stripe_product_trail ? $plan->stripe_product_trail : 0
            ];
        } else {
            $subscriptionData = [];
        }

        try {
            if (isset($stripeProductId) && !empty($stripeProductId)) {
                // Fetch the product to get its prices
                $prices = \Stripe\Price::all(['product' => $stripeProductId]);

                // Ensure we have an active price for subscription
                if (count($prices->data) > 0) {
                    $priceId = $prices->data[0]->id; // Get the first price ID (make sure it’s active)

                    // Create a subscription-based payment session
                    $checkout_session = \Stripe\Checkout\Session::create([
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price' => $priceId, // Use the Stripe price ID for subscription
                            'quantity' => 1,
                        ]],
                        'mode' => 'subscription',
                        'subscription_data' => $subscriptionData,
                        'success_url' => url('/stripe/success?checkout_session_id={CHECKOUT_SESSION_ID}'),
                        'cancel_url' => url('/monetization/cancel'),
                    ]);
                } else {
                    throw new \Exception("No active price found for the product.");
                }
            } else {
                // Create a one-time payment session
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
                            'currency' => \App\Services\AppConfig::get()->app->colors_assets_for_branding->payment_currency_code,
                        ],
                        'quantity' => 1
                    ]],
                    'mode' => 'payment',
                    'success_url' => url('/stripe/success?checkout_session_id={CHECKOUT_SESSION_ID}'),
                    'cancel_url' => url('/monetization/cancel'),
                ]);
            }
        } catch (\Exception $e) {
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
                'error' => [
                    'message' => 'Checkout Session creation failed! ' . $api_error
                ]
            ]);
        }
    }

    public function success(Request $request)
    {
        $payment_id = $statusMsg = '';
        $status = 'error';
        $title = 'Great!';
        $error = false;
        $api_error = '';
        $subscriptionId = null;

        // Check whether stripe checkout session is not empty
        if ($request->checkout_session_id) {
            $session_id = $request->checkout_session_id;

            // Set API key
            if (env('STRIPE_TEST') === 'true') {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            } else {
                \Stripe\Stripe::setApiKey(\App\Services\AppConfig::get()->app->colors_assets_for_branding->stripe_secret_key);
            }

            // Fetch the Checkout Session
            try {
                $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
            } catch (\Exception $e) {
                $error = true;
                $api_error = $e->getMessage();
            }

            if (!$error && $checkout_session) {
                // Get customer details
                $customer_details = $checkout_session->customer_details;

                // Check if the session is for a subscription
                if ($checkout_session->mode === 'subscription') {
                    // Retrieve subscription details
                    try {
                        $subscription = \Stripe\Subscription::retrieve($checkout_session->subscription);

                        // Ensure the subscription was retrieved successfully
                        if ($subscription) {
                            $subscriptionId = $subscription->id;
                            // Check if latest_invoice exists and is valid
                            if (isset($subscription->latest_invoice) && !empty($subscription->latest_invoice)) {
                                $latestInvoiceId = $subscription->latest_invoice;

                                // Retrieve PaymentIntent details
                                try {
                                    $latestInvoice = \Stripe\Invoice::retrieve($latestInvoiceId);
                                    if ($latestInvoice && isset($latestInvoice->payment_intent)) {
                                        $paymentIntentId = $latestInvoice->payment_intent;

                                        // Retrieve the PaymentIntent
                                        if ($paymentIntentId) {
                                            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
                                        }
                                    }
                                } catch (\Stripe\Exception\ApiErrorException $e) {
                                    $error = true;
                                    $api_error = $e->getMessage();
                                }
                            } else {
                                $error = true;
                                $api_error = "Latest invoice not found or is not valid.";
                            }
                        }
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        $error = true;
                        $api_error = $e->getMessage();
                    }
                } else {
                    // Retrieve PaymentIntent for one-time payments
                    try {
                        $paymentIntent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        $error = true;
                        $api_error = $e->getMessage();
                    }
                }

                // Payment processing logic
                if (!$error && isset($paymentIntent)) {
                    // Check whether the payment was successful
                    if ($paymentIntent->status === 'succeeded') {
                        // Transaction details
                        $transactionID = $checkout_session->subscription ? $checkout_session->subscription : $paymentIntent->id;
                        $paidAmount = $paymentIntent->amount / 100; // Convert from cents
                        $paidCurrency = $paymentIntent->currency;

                        // Customer info
                        $customer_name = $customer_details->name ?? '';
                        $customer_email = $customer_details->email ?? '';

                        // Prepare data for processing
                        $arrFormData = [
                            'requestAction' => 'sendPaymentInfo',
                            'transactionId' => $subscriptionId ? $subscriptionId : $transactionID,
                            'amount' => $paidAmount,
                            'monetizationGuid' => session('MONETIZATION')['MONETIZATION_GUID'],
                            'subsType' => session('MONETIZATION')['SUBS_TYPE'],
                            'paymentInformation' => session('MONETIZATION')['PAYMENT_INFORMATION'],
                            'gift_recipient_email' => session('MONETIZATION')['RECIPIENT_EMAIL'] ?? null,
                            'tip' => session('MONETIZATION')['TIP'] ?? null,
                        ];
                        // $arrRes = GeneralHelper::sendCURLRequest(0, Api::endpoint('/sendpaymentdetails'), $arrFormData);
                        $response = Http::timeout(300)->withHeaders(Api::headers([
                            'husercode' => session('USER_DETAILS')['USER_CODE']
                        ]))
                            ->asForm()
                            ->post(Api::endpoint('/sendpaymentdetails'), $arrFormData);
                        $arrRes = $response->json();
                        if ($arrRes && session()->has('USER_DETAILS') && isset($arrRes['app']['group_user']) && !empty($arrRes['app']['group_user'])) {
                            $userDetails = session()->get('USER_DETAILS'); // Retrieve session data properly
                            $userDetails['GROUP_USER'] = $arrRes['app']['group_user']; // Update the value
                            session()->put('USER_DETAILS', $userDetails); // Store it back in session
                        }                        
                        $status = 'success';
                        $statusMsg = $arrRes['app']['msg'];
                        $title = 'Great!';
                    } else {
                        $statusMsg = "Transaction has failed!";
                        $title = 'Oops!';
                    }
                } else {
                    $statusMsg = "Unable to fetch the transaction details! $api_error";
                    $title = 'Oops!';
                }
            } else {
                $statusMsg = "Invalid Transaction! $api_error";
                $title = 'Oops!';
            }
        } else {
            $statusMsg = "Invalid Request!";
            $title = 'Oops!';
        }

        session()->flash("stripe_payment_processed", true);
        session()->flash("statusMsg", $statusMsg);
        session()->flash("title", $title);

        return redirect('/monetization/success');
    }

    public function cancelsub($subid)
    {
         $stripeKey = env('STRIPE_TEST') === 'true'
        ? env('STRIPE_SECRET_KEY')
        : \App\Services\AppConfig::get()->app->colors_assets_for_branding->stripe_secret_key;

        $stripe = new \Stripe\StripeClient($stripeKey);
        
        try {
            $invoice = $stripe->invoices->retrieve($subid);
            $subid = $invoice->subscription;
                   
            if($subid)
            {
                $stripe->subscriptions->cancel($subid, []);
                Log::info("Stripe subscription cancelled: $subid");
            }
            
        } catch (\Exception $e) {
            Log::error("Unexpected error cancelling Stripe subscription {$subid}: " . $e->getMessage());
        }

        $response = Http::timeout(300)->withHeaders(Api::headers([
            'husercode' => session('USER_DETAILS')['USER_CODE']
        ]))
            ->asForm()
            ->get(Api::endpoint('/updateTransaction/' . $subid));

        $responseJson = $response->json();

        if (isset($responseJson['success'])) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

   public function pauseSubscription(Request $request)
    {
        $days = (int) $request->days;
        $subscriptionId = $request->subscription_id;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $actualSubscriptionId = null;

        try {
            $invoice = $stripe->invoices->retrieve($subscriptionId);
            if (!empty($invoice->subscription)) {
                $actualSubscriptionId = $invoice->subscription;
                try {
                    $stripe->subscriptions->update($actualSubscriptionId, [
                        'pause_collection' => [
                            'behavior' => 'mark_uncollectible',
                        ],
                    ]);
                    Log::info("Subscription paused via invoice: {$actualSubscriptionId}");
                } catch (\Exception $e) {
                    Log::error("Failed to pause subscription {$actualSubscriptionId}: " . $e->getMessage());
                }
            } else {
                Log::warning("No subscription found in invoice: {$subscriptionId}");
            }
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            
            Log::warning("Invalid or missing Stripe invoice ID: {$subscriptionId} - " . $e->getMessage());
        } catch (\Exception $e) {
            Log::error("Unexpected error during Stripe invoice retrieval: " . $e->getMessage());
        }

        try {
            $response = Http::timeout(300)->withHeaders(Api::headers([
                'husercode' => session('USER_DETAILS')['USER_CODE']
            ]))
            ->asForm()
            ->get(Api::endpoint('/pause_days/' . $days . '/subscription_id/' . ($actualSubscriptionId ?? $subscriptionId)));

            $responseJson = $response->json();
        } catch (\Exception $e) {
            Log::error("Internal API call failed: " . $e->getMessage());
        }

        return response()->json([
            'message' => 'Pause subscription process completed.',
            'days' => $days
        ]);
    }





    // public function success(Request $request)
    // {
    //     try {
    //         // $session_id = $request->query('session_id');
    //         // $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
    //         // $paymentIntent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
    //         // $customer_details = $checkout_session->customer_details;
    //         // $transactionID = $paymentIntent->id;
    //         // $paidAmount = $paymentIntent->amount / 100;
    //         // $paidCurrency = $paymentIntent->currency;
    //         // $payment_status = $paymentIntent->status;

    //         return redirect('/monetization/success');
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => $th->getMessage()], 500);
    //     }
    // }

    /**
    *   Set API key
    *  if (env('STRIPE_TEST') === 'true') {
    *     $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
    * } else {
    *    $stripe = new \Stripe\StripeClient(\App\Services\AppConfig::get()->app->colors_assets_for_branding->stripe_secret_key);
    *}
    *$cancelsub = null;
    *if ($stripe) {
    *   $cancelsub = $stripe->subscriptions->cancel($subid, []);
    *}
    */
}
