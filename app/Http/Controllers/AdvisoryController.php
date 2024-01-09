<?php

namespace App\Http\Controllers;

use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdvisoryController extends Controller
{
    public function index($id)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/getcategoryitems/' . $id), [
                'type' => 'advisory',
            ]);
        $responseJson = $response->json();

        $categories = $responseJson['app']['categories'];
        return view('category.index', compact('categories'));
    }
}
