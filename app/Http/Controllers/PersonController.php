<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        return view('person.index');
    }
}
