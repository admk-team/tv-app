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
            'cat_type' => 'nullable',
            'menu_guid' => 'nullable',
            'menu_type' => 'nullable',
        ]);

        // Make the API request with form-data
        $response = Http::withHeaders(Api::headers())
            ->asForm()->post(Api::endpoint('/steamcategory'), [
                'cat_guid' => $validateData['cat_guid'] ?? null,
                'cat_type' => $validateData['cat_type'] ?? null,
                'menu_guid' => $validateData['menu_guid'] ?? null,
                'menu_type' => $validateData['menu_type'] ?? null,
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

    public function renderCategorySlider(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'category' => 'required|array',
            'category.cat_guid' => 'required',
            'category.cat_title' => 'nullable',
            'category.cat_type' => 'nullable',
            'category.card_type' => 'nullable',
            'category.is_show_view_more' => 'nullable',
            'category.items_per_row' => 'nullable|integer',
            'category.is_top10' => 'nullable',
            'streams' => 'required|array',
        ]);

        // Prepare category object by merging validated category data with streams
        $category = (object) array_merge($validated['category'], [
            'streams' => $validated['streams'],
        ]);

        // Set default values if not provided
        $category->card_type = $category->card_type ?? ($category->cat_type ?? 'LA');
        $category->is_show_view_more = $category->is_show_view_more ?? 'Y';
        $category->items_per_row = $category->items_per_row ?? 5;
        $category->is_top10 = $category->is_top10 ?? 'N';

        // Render the Blade component
        return response()->json([
            'success' => true,
            'html' => view('components.include_file_cat_slider', compact('category'))->render(),
        ]);
    }

}
