<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSubdomainRequest;
use Illuminate\Support\Facades\Http;

class SiteDeleteController extends Controller
{
    public function deleteSubdomain(DeleteSubdomainRequest $request)
    {
        $input = $request->validated();
        $subdomain = $input['subdomain'];
        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://147.93.114.167:8090/api/deleteWebsite', [
            "adminUser" => "admin",
            "adminPass" => "2MQVOWTfUdFJLTJw",
            "domainName" => $subdomain . '.octv.online',
        ]);
        return response()->json($response->json());
    }
}
