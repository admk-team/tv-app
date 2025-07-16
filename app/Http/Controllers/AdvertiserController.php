<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Api;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdvertiserController extends Controller
{
    public function bannerAd()
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/banner_ad'));
        $responseJson = $response->json();
        // Check if API call is successful
        if (!empty($responseJson['success']) && $responseJson['success'] === true) {
            $record = $responseJson['data'];
        } else {
            $record = [];
        }

        return view('advertiser_banner_ads.index', compact('record'));
    }

    public function bannerAdReport($id)
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }

        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/banner_ad/report/' . $id));

        $responseJson = $response->json();

        // Check if 'events' is present and is an array
        $events = collect([]);
        if (isset($responseJson['data']['events']) && is_array($responseJson['data']['events'])) {
            $events = collect($responseJson['data']['events']);
        }

        // Paginate the `events` array
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $events->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedEvents = new LengthAwarePaginator(
            $currentPageItems,
            $events->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Replace events with the paginated version
        $responseJson['data']['events'] = $paginatedEvents;

        return view('advertiser_banner_ads.banner_ad_report', ['data' => $responseJson]);
    }

    public function overlayAd()
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/overlay_ad'));
        $responseJson = $response->json();
        // Check if API call is successful
        if (!empty($responseJson['success']) && $responseJson['success'] === true) {
            $record = $responseJson['data'];
        } else {
            $record = [];
        }

        return view('adveritiser_overlay_ad.index', compact('record'));
    }


    public function overlayAdReport($id)
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }

        // Call the internal API or service to fetch report
        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/overlay_ad/report/' . $id));

        $responseJson = $response->json();
        $events = collect([]);
        if (isset($responseJson['data']['events']) && is_array($responseJson['data']['events'])) {
            $events = collect($responseJson['data']['events']);
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $events->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedEvents = new LengthAwarePaginator(
            $currentPageItems,
            $events->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $responseJson['data']['events'] = $paginatedEvents;

        return view('adveritiser_overlay_ad.overlay_ad_report', ['data' => $responseJson]);
    }

    public function videoAd()
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/video_ad'));
        $responseJson = $response->json();
        // Check if API call is successful
        if (!empty($responseJson['success']) && $responseJson['success'] === true) {
            $record = $responseJson['data'];
        } else {
            $record = [];
        }

        return view('adveritiser_video_ad.index', compact('record'));
    }
    public function videoAdReport($id)
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }

        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/video_ad/report/' . $id));

        $responseJson = $response->json();
        // Paginate the `events` array
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $events = collect($responseJson['data']['events']);
        $perPage = 10;
        $currentPageItems = $events->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedEvents = new LengthAwarePaginator(
            $currentPageItems,
            $events->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // Replace full events with paginated ones
        $responseJson['data']['events'] = $paginatedEvents;

        return view('adveritiser_video_ad.video_ad_report', ['data' => $responseJson]);
    }
}
