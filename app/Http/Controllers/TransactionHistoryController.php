<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders(Api::headers([
            'husercode' => session('USER_DETAILS')['USER_CODE']
        ]))
            ->asForm()
            ->post(Api::endpoint('/getsubscriptionhistory'));
        $responseJson = $response->json();

        $subsHistory = $responseJson['app']['subs_history'];
        $subsMsg = $responseJson['app']['msg'];
        return view('transaction-history.index', compact('subsHistory', 'subsMsg'));
    }
}
