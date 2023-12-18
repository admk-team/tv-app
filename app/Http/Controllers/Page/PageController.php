<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug)
    {
        if ($slug == 'contact-us') {
            return view("page.contact-us", compact('slug'));
        } else {
            return view("page.index", compact('slug'));
        }
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required | email',
            'message' => 'required',
        ]);

        $form_data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'mobile' => $request->input('mobile') ?? '',
            'requestAction' => 'sendInquiry',
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'happcode' => '7376d3829575f06617d9db3f7f6836df',
        ])->post(env('API_BASE_URL') . '/sendcontactdetail', $form_data);

        $responseData = $response->json();
        return $responseData;
    }
}