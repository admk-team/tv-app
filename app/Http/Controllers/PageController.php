<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Api;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($slug)
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
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

        $response = Http::timeout(300)->withHeaders(Api::headers())->post(env('API_BASE_URL') . '/sendcontactdetail', $form_data);

        $jsonResponse = $response->json();
        $message = $jsonResponse['app']['msg'];
        if ($response->successful()) {
            return back()->with('success', $message);
        } else {
            return back()->withErrors(['error' => 'Failed to submit contact form.']);
        }
    }
}
