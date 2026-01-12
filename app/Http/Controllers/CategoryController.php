<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index($categoryCode, $menuCode = null)
    {
     
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/getcategoryitems/' . $categoryCode . '/' . ($menuCode ?? '')), [
                'type' => request()->type ?? 'category',
            ]);
        $responseJson = $response->json();

        if (!isset($responseJson['app']['categories']))
            abort(404);

        $categories = $responseJson['app']['categories'];
        return view('category.index', compact('categories'));
    }

 public function index1($categoryCode)
    {
       
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $response = Http::withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/getcategoryitems/' . $categoryCode), [
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
        $cachedData = Cache::remember($cacheKey, now()->addMinutes(2), function () use ($validateData) {
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

                    // Log views data for all streams in this category
                    $catGuid = $validateData['cat_guid'] ?? 'unknown';
                    $catType = $validateData['cat_type'] ?? 'unknown';
                    $viewsData = [];
                    foreach ($responseJson['streams'] as $index => $stream) {
                        $streamGuid = $stream['stream_guid'] ?? 'unknown';
                        $streamTitle = $stream['stream_title'] ?? 'unknown';
                        $views = $stream['views'] ?? $stream['total_views'] ?? $stream['view_count'] ?? 0;
                        $viewsData[] = [
                            'stream_guid' => $streamGuid,
                            'stream_title' => $streamTitle,
                            'views' => $views,
                            'has_views_field' => isset($stream['views']),
                            'has_total_views_field' => isset($stream['total_views']),
                            'has_view_count_field' => isset($stream['view_count']),
                        ];
                    }
                    Log::info("Category Streams Views Data", [
                        'category_guid' => $catGuid,
                        'category_type' => $catType,
                        'total_streams' => count($responseJson['streams']),
                        'streams_with_views' => count(array_filter($viewsData, fn($s) => $s['views'] > 0)),
                        'views_data' => $viewsData,
                    ]);

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
            'category.menu_guid' => 'nullable',
            'category.menu_type' => 'nullable',
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
        $category->menu_guid = $category->menu_guid ?? null;
        $category->menu_type = $category->menu_type ?? 'N';
        
        // Debug: Check current request info
        $currentUrl = request()->fullUrl();
        $routeName = request()->route()->getName();
        $isHomePage = request()->is('/') || $routeName === 'home';
        
        // Also check if this is an AJAX request from the home page
        $referer = request()->header('referer');
        $isFromHomePage = $isHomePage || ($referer && str_contains($referer, request()->getSchemeAndHttpHost() . '/'));
        
        Log::info("Category Slider Debug", [
            'current_url' => $currentUrl,
            'route_name' => $routeName,
            'is_home_page' => $isHomePage,
            'is_from_home_page' => $isFromHomePage,
            'referer' => $referer,
            'original_menu_type' => $category->menu_type ?? 'NOT_SET',
            'category_guid' => $category->cat_guid ?? 'NO_GUID',
        ]);
        
     
        
        // Log views data before rendering
        $catGuid = $category->cat_guid ?? 'unknown';
        $catTitle = $category->cat_title ?? 'unknown';
        $viewsSummary = [];
        foreach ($validated['streams'] as $stream) {
            $streamGuid = $stream['stream_guid'] ?? 'unknown';
            $streamTitle = $stream['stream_title'] ?? 'unknown';
            $views = $stream['views'] ?? $stream['total_views'] ?? $stream['view_count'] ?? 0;
            $viewsSummary[] = [
                'stream_guid' => $streamGuid,
                'stream_title' => $streamTitle,
                'views' => $views,
                'views_type' => isset($stream['views']) ? 'views' : (isset($stream['total_views']) ? 'total_views' : (isset($stream['view_count']) ? 'view_count' : 'none')),
            ];
        }
        Log::info("Rendering Category Slider with Views", [
            'category_guid' => $catGuid,
            'category_title' => $catTitle,
            'total_streams' => count($validated['streams']),
            'streams_with_views' => count(array_filter($viewsSummary, fn($s) => $s['views'] > 0)),
            'views_summary' => $viewsSummary,
        ]);

        // Render the Blade component
        return response()->json([
            'success' => true,
            'html' => view('components.include_file_cat_slider', compact('category'))->render(),
        ]);
    }
}
