<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

        // Generate a unique cache key based on input
        $cacheKey = 'streams_' . md5(json_encode([
            $validateData['cat_guid'],
            $validateData['cat_type'],
            $validateData['menu_guid'],
            $validateData['menu_type'],
        ]));

        // Try retrieving from cache
        $cachedData = Cache::remember($cacheKey, now()->addMinutes(3), function () use ($validateData) {
            try {
                $response = Http::withHeaders(Api::headers())
                    ->asForm()
                    ->post(Api::endpoint('/streamcategory'), [
                        'cat_guid' => $validateData['cat_guid'] ?? null,
                        'cat_type' => $validateData['cat_type'] ?? null,
                        'menu_guid' => $validateData['menu_guid'] ?? null,
                        'menu_type' => $validateData['menu_type'] ?? null,
                    ]);

                if ($response->successful()) {
                    $responseJson = $response->json();

                    if (!is_array($responseJson) || !isset($responseJson['streams']) || !is_array($responseJson['streams'])) {
                        return null;
                    }

                    return [
                        'success' => true,
                        'data' => [
                            'streams' => $responseJson['streams']
                        ]
                    ];
                }

                return null;
            } catch (\Exception $e) {
                Log::error('API error in getStreams: ' . $e->getMessage());
                return null;
            }
        });

        // Handle cached or null data
        if (!$cachedData) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve streams from API.',
            ], 500);
        }

        return response()->json($cachedData);
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
