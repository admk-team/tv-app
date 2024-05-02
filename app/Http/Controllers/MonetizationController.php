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
            session()->forget('coupon_applied'); // Remove old
            session()->put([
                'MONETIZATION' => $request->only([
                    'AMOUNT',
                    'SUBS_TYPE',
                    'MONETIZATION_GUID',
                    'PAYMENT_INFORMATION',

                    'PLAN',
                    'MONETIZATION_TYPE',
                    'PLAN_TYPE',
                    'PLAN_PERIOD',
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
        $response = Http::withHeaders(Api::headers())
            ->post(Api::endpoint('/coupon'), [
                'offer' => $request->coupon_code,
            ]);
        
        $responseJSON = $response->json();

        if ($responseJSON['status'] === 0) {
            session()->flash('coupon_applied_error', 'The coupon is invalid or expired!');
            return back();
        }

        $amount = session('MONETIZATION.AMOUNT');
        $discount = 0;
        if ($responseJSON['data']['discount_type'] === 'percentage') {
            $discount = ($responseJSON['data']['discount'] / 100) * $amount;
        }
        else {
            $discount = $responseJSON['data']['discount'];
        }
        $finalAmount = $amount - $discount;
        // if ($finalAmount < 0.99) {
        //     $finalAmount = 1;
        // }
        if ($finalAmount < 0) {
            $finalAmount = 0;
        }

        session()->put('MONETIZATION.AMOUNT', $finalAmount);

        session()->flash('coupon_applied_success', 'Coupont successfully applied!');
        session()->put('coupon_applied', true);
        return back();
    }
}