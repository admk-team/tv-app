<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\Api;

class PasswordUpdateController extends Controller
{
    public function index()
    {
        return view('change-password.index');
    }

    public function update(UpdatePasswordRequest $request)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->post(Api::endpoint('/mngappusrs'), [
                'oldPassword' => $request->oldPassword,
                'nPassword' => $request->password,
                'cPassword' => $request->password_confirmation,
                'userCode' => session('USER_DETAILS')['USER_CODE'],
                'requestAction' => 'changeAccountPassword',
            ]);
        $responseJson = $response->json();

        if ($responseJson['app']['status'] === 0) {
            return back()->with('error', $responseJson['app']['msg']);
        } else {
            return back()->with('success', $responseJson['app']['msg']);
        }
    }
}
