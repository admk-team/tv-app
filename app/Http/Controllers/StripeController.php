<?php

namespace App\Http\Controllers;

use \Stripe\Stripe;
use App\Services\Api;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;

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
                        'currency' => \App\Services\AppConfig::get()->app->colors_assets_for_branding->payment_currency_code,
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

    public function success(Request $request)
    {
        $payment_id = $statusMsg = ''; 
        $status = 'error';
        $title = 'Great!';
        $error = false;
        
        // Check whether stripe checkout session is not empty 
        if($request->session_id){ 
            $session_id = $request->session_id; 
            // Include the Stripe PHP library 
            
            // Set API key
            if (env('STRIPE_TEST') === true) {
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            } else {
                \Stripe\Stripe::setApiKey(\App\Services\AppConfig::get()->app->colors_assets_for_branding->stripe_secret_key);
            }
            
            // Fetch the Checkout Session to display the JSON result on the success page 
            try { 
                $checkout_session = \Stripe\Checkout\Session::retrieve($session_id); 
            } catch(\Exception $e) {  
                $error = true;
                $api_error = $e->getMessage();  
            } 
            
            if(!$error && $checkout_session){ 
                
                // Get customer details 
                $customer_details = $checkout_session->customer_details; 

                // Retrieve the details of a PaymentIntent 
                try { 
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent); 
                } catch (\Stripe\Exception\ApiErrorException $e) { 
                    $error = true;
                    $api_error = $e->getMessage(); 
                } 

                if(!$error && $paymentIntent){ 
                    // Check whether the payment was successful 
                    if(!empty($paymentIntent) && $paymentIntent->status == 'succeeded'){ 
                        // Transaction details  
                        $transactionID = $paymentIntent->id; 
                        $paidAmount = $paymentIntent->amount; 
                        $paidAmount = ($paidAmount/100); 
                        $paidCurrency = $paymentIntent->currency; 
                        $payment_status = $paymentIntent->status; 
                        
                        // Customer info 
                        $customer_name = $customer_email = ''; 
                        if(!empty($customer_details)){ 
                            $customer_name = !empty($customer_details->name)?$customer_details->name:''; 
                            $customer_email = !empty($customer_details->email)?$customer_details->email:''; 
                        } 

                        $arrFormData['requestAction'] = 'sendPaymentInfo';
                        $arrFormData['transactionId'] = $transactionID; //md5(time());
                        $arrFormData['amount'] =  $paidAmount; //$_SESSION['MONETIZATION']['AMOUNT'];
                        $arrFormData['monetizationGuid'] = session('MONETIZATION')['MONETIZATION_GUID'];
                        $arrFormData['subsType'] = session('MONETIZATION')['SUBS_TYPE'];
                        $arrFormData['paymentInformation'] = session('MONETIZATION')['PAYMENT_INFORMATION'];
                        $arrRes = GeneralHelper::sendCURLRequest(0, Api::endpoint('/sendpaymentdetails'), $arrFormData);
                        $status = 'success'; 
                        $statusMsg = $arrRes['app']['msg']; 
                        $title = 'Great!';
                    }else{ 
                        $statusMsg = "Transaction has been failed!"; 
                        $title = 'Oops!';
                    } 
                }else{ 
                    $statusMsg = "Unable to fetch the transaction details! $api_error";  
                    $title = 'Oops!';
                }
            }else{
                $statusMsg = "Invalid Transaction! $api_error"; 
                $title = 'Oops!';
            }

        }else{
            $statusMsg = "Invalid Request!"; 
            $title = 'Oops!';
        }

        session()->flash("stripe_payment_processed", true);
        session()->flash("statusMsg", $statusMsg);
        session()->flash("title", $title);

        return redirect('/monetization/success');
    }

}