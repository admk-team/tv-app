<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index()
    {
        if (session()->has('USER_DETAILS'))
            session()->flush();

        return redirect(route('home'));
    }
}
