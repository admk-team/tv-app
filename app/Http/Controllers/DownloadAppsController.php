<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadAppsController extends Controller
{
    public function index()
    {
        return view('download_apps.index');
    }
}
