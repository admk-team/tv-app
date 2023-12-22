<?php

namespace App\Http\Controllers\Monetization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonetizationController extends Controller
{
    public function index(Request $request)
    {
        $planData = $request->all();
        return view('monetization.index', compact('planData'));
    }

    public function cancel()
    {
        return redirect('/');
    }
}
