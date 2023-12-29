<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->searchKeyword;

        $response = Http::timeout(300)->withHeaders(Api::headers())
            ->asForm()
            ->post(Api::endpoint('/search'), [
                'postAction' => 'search',
                'maxShowStream' => 50,
                'keyword' => $keyword
            ]);
        $responseJson = $response->json();
        $searchResult = $responseJson['search_result'];

        return view('search.index', compact('searchResult', 'keyword'));
    }
}
