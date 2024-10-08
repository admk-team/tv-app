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
        $response = Http::timeout(300)->withHeaders(Api::headers([
            'husercode' => session('USER_DETAILS')['USER_CODE']
        ]))
            ->asForm()
            ->get(Api::endpoint('/getsubscriptionhistory'));
        $responseJson = $response->json();
        if (isset($responseJson['app']['subs_history'])) {
            $subsHistory = $responseJson['app']['subs_history'];
        } else {
            $subsHistory = [];
        }

        if (isset($responseJson['app']['msg'])) {
            $subsMsg = $responseJson['app']['msg'];
        } else {
            $subsMsg = "No Subscription History Found !";
        }

        // $subsMsg = $responseJson['app']['msg'];
        return view('transaction-history.index', compact('subsHistory', 'subsMsg'));
    }
}
