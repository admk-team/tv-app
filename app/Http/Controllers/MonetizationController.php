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
        session()->put([
            'MONETIZATION' => $request->only([
                'AMOUNT',
                'SUBS_TYPE',
                'MONETIZATION_GUID',
                'PAYMENT_INFORMATION',
            ])
        ]);
        $planData = $request->all();

        return view('monetization.index', compact('planData'));
    }

    public function success()
    {
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
                'paymentInformation' => session('MONETIZATION')['PAYMENT_INFORMATION'],
            ]);
        $responseJson = $response->json();

        return view('monetization.success', compact('transactionId'));
    }

    public function cancel()
    {
        return view('monetization.cancel');
    }
}