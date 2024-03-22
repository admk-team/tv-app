<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class MonetizationController extends Controller
{
    public function index(Request $request)
    {
        $planData = null;
        
        if (strtolower($request->method()) === 'post') {
            session()->put([
                'MONETIZATION' => $request->only([
                    'AMOUNT',
                    'SUBS_TYPE',
                    'MONETIZATION_GUID',
                    'PAYMENT_INFORMATION',
                ])
            ]);
            $planData = $request->all();
        }
        else {
            $planData = session('MONETIZATION');
        }

        return view('monetization.index', compact('planData'));
    }

    public function success(Request $request)
    {
        if (session()->has('stripe_payment_processed') && session()->get('stripe_payment_processed')) {
            return view('monetization.success_stripe');
        }
        else {
            if($request->txn_id){
                $transactionId = $request->txn_id;
                $paymentInfo = json_encode($request->all());
            }
            else
            {
                $transactionId = md5(time()); 
                $paymentInfo = session('MONETIZATION')['PAYMENT_INFORMATION'];       
            }

            $transactionId = md5(time());
    
            $response = Http::timeout(300)->withHeaders(Api::headers([
                'husercode' => session('USER_DETAILS')['USER_CODE']
            ]))
                ->asForm()
                ->post(Api::endpoint('/sendpaymentdetails'), [
                    'transactionId' => $transactionId,
                    'requestAction' => 'sendPaymentInfo',
                    'amount' => session('MONETIZATION')['AMOUNT'],
                    'monetizationGuid' => session('MONETIZATION')['MONETIZATION_GUID'],
                    'subsType' => session('MONETIZATION')['SUBS_TYPE'],
                    'paymentInformation' => $paymentInfo,
                ]);
            $responseJson = $response->json();
    
            return view('monetization.success', compact('transactionId', 'responseJson'));
        }
    }

    public function cancel()
    {
        return view('monetization.cancel');
    }

    public function applyCoupon(Request $request)
    {
        
    }
}