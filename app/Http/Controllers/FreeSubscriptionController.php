<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class FreeSubscriptionController extends Controller
{
    public function index()
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

        return view('free-subscription.index');
    }
}