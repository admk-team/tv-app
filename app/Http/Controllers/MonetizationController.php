<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppCofig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class MonetizationController extends Controller
{
    public function index(Request $request)
    {
        $planData = null;
        $recipientEmail = $request->query('recipient_email');

        if (strtolower($request->method()) === 'post') {
            session()->forget('coupon_applied'); // Remove old

            // Store the monetization data in the session
            $monetizationData = $request->only([
                'AMOUNT',
                'SUBS_TYPE',
                'MONETIZATION_GUID',
                'PAYMENT_INFORMATION',
                'PLAN',
                'PAYPAL_PLAN_ID',
                'PAYPAL_PLAN_NAME',
                'PAYPAL_PLAN_DURATION',
                'PAYPAL_PLAN_PRICE',
                'PAYPAL_PLAN_TRAIL',
                'MONETIZATION_TYPE',
                'PLAN_TYPE',
                'PLAN_PERIOD',
                'RECIPIENT_EMAIL',
                // Include the Stripe fields
                'stripe_product_id',
                'stripe_product_name',
                'stripe_product_price',
                'stripe_product_interval',
            ]);

            // Include recipient email if present
            if ($recipientEmail) {
                $monetizationData['RECIPIENT_EMAIL'] = $recipientEmail;
            }

            session()->put('MONETIZATION', $monetizationData);
            $planData = $monetizationData;
        } else {
            $planData = session('MONETIZATION');

            // Optionally add recipient email to the planData if needed
            if ($recipientEmail) {
                $planData['RECIPIENT_EMAIL'] = $recipientEmail;
                session()->put('MONETIZATION.RECIPIENT_EMAIL', $recipientEmail);
            }
        }
        return view('monetization.index', compact('planData'));
    }

    public function tipjar(Request $request)
    {
        session()->put(
            'MONETIZATION.PAYMENT_INFORMATION',
            'Tip The Creator',
        );
        session()->put(
            'MONETIZATION.SUBS_TYPE',
            'O',
        );
        session()->put(
            'MONETIZATION.TIP',
            1,
        );
        session()->put('MONETIZATION.MONETIZATION_GUID', $request->streamcode);
        $planData = [
            'PAYMENT_INFORMATION' => 'Tip The Creator',
            'MONETIZATION_GUID' => $request->streamcode,
            'POSTER' => $request->streamposter,
        ];

        return view('monetization.tipjar', compact('planData'));
    }

    public function success(Request $request)
    {
        if (session()->has('stripe_payment_processed') && session()->get('stripe_payment_processed')) {
            return view('monetization.success_stripe');
        } else {
            if ($request->txn_id) {
                $transactionId = $request->txn_id;
                $paymentInfo = json_encode($request->all());
            } else {
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
                    'tip' => session('MONETIZATION')['TIP'] ?? null,
                    'paymentInformation' => $paymentInfo,
                ]);
            $responseJson = $response->json();
            if ($responseJson && session()->has('USER_DETAILS') && isset($responseJson['app']['group_user']) && !empty($responseJson['app']['group_user'])) {
                $userDetails = session()->get('USER_DETAILS'); // Retrieve session data properly
                $userDetails['GROUP_USER'] = $responseJson['app']['group_user']; // Update the value
                session()->put('USER_DETAILS', $userDetails); // Store it back in session
            }   
            return view('monetization.success', compact('transactionId', 'responseJson'));
        }
    }

    public function cancel()
    {
        return view('monetization.cancel');
    }

    public function applyCoupon(Request $request)
    {
        $response = Http::withHeaders(Api::headers(['Accept' => 'application/json']))
            ->post(Api::endpoint('/coupon'), [
                'offer' => $request->coupon_code,
                'monetization_guid' => session('MONETIZATION.MONETIZATION_GUID'),
                'monetization_type' => session('MONETIZATION.MONETIZATION_TYPE'),
            ]);

        $responseJSON = $response->json();

        if (($responseJSON['status'] ?? 0) === 0) {
            session()->flash('coupon_applied_error', 'The coupon is invalid or expired!');
            return back();
        }

        $amount = session('MONETIZATION.AMOUNT');
        $discount = 0;
        if ($responseJSON['data']['discount_type'] === 'percentage') {
            $discount = ($responseJSON['data']['discount'] / 100) * $amount;
        } else {
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

        session()->flash('coupon_applied_success', 'Coupon successfully applied!');
        session()->put('coupon_applied', true);
        return back();
    }
}
