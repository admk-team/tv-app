<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class CategoryController extends Controller
{
    public function index($id)
    {
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/getcategoryitems/' . $id), [
                'type' => request()->type ?? 'category',
            ]);
        $responseJson = $response->json();

        if (!isset($responseJson['app']['categories']))
            abort(404);

        $categories = $responseJson['app']['categories'];
        return view('category.index', compact('categories'));
    }
}
