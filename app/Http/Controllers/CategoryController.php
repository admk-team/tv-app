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
    public function getStreams(Request $request)
    {
        // Validate required fields
       $validateData = $request->validate([
            'cat_guid' => 'nullable',
            'cat_title' => 'nullable',
            'cat_type' => 'nullable',
        ]);
       dd($validateData);
        // Make the API request with form-data
        $response = Http::withHeaders(Api::headers())
            ->asForm()->post(Api::endpoint('/category/streams/'), [
                'cat_guid' =>   $validateData['cat_guid'] ?? null,
                'cat_title' => $validateData['cat_title'] ?? null,
                'cat_type' => $validateData['cat_type'] ?? null,
            ]);

        // Check if the request was successful
        if ($response->successful()) {
            $responseJson = $response->json();

            // Validate response structure
            if (!is_array($responseJson) || !isset($responseJson['streams']) || !is_array($responseJson['streams'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response format from API.',
                ], 500);
            }

            // Construct category data for frontend
            $category = [
                'streams' => $responseJson['streams'],
            ];
            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        }

        // Handle unsuccessful API response
        return response()->json([
            'success' => false,
            'message' => 'Failed to retrieve streams from API.',
        ], $response->status());
    }

}
