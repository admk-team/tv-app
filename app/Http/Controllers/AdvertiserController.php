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

        $response = Http::timeout(60)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/banner_ad/report/' . $id), [
                'per_page' => 10,
                'page' => request()->get('page', 1),
            ]);

        $responseJson = $response->json();
        $paginatedEvents = null;

        if (
            $response->ok() &&
            isset($responseJson['success']) &&
            $responseJson['success'] === true &&
            isset($responseJson['data']['events']['data']) // Ensure pagination structure exists
        ) {
            $eventsData = $responseJson['data']['events'];

            $paginatedEvents = new \Illuminate\Pagination\LengthAwarePaginator(
                $eventsData['data'],
                $eventsData['total'],
                $eventsData['per_page'],
                $eventsData['current_page'],
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

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
            ->get(Api::endpoint('/advertiser/overlay_ad/report/' . $id), [
                'per_page' => 10,
                'page' => request()->get('page', 1)
            ]);

        $responseJson = $response->json();

        $paginatedEvents = null;

        if (
            $response->ok() &&
            isset($responseJson['success']) &&
            $responseJson['success'] === true &&
            isset($responseJson['data']['events']['data']) // Ensure pagination structure exists
        ) {
            $eventsData = $responseJson['data']['events'];

            $paginatedEvents = new \Illuminate\Pagination\LengthAwarePaginator(
                $eventsData['data'],
                $eventsData['total'],
                $eventsData['per_page'],
                $eventsData['current_page'],
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

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
            ->get(Api::endpoint('/advertiser/video_ad/report/' . $id), [
                'per_page' => 10,
                'page' => request()->get('page', 1)
            ]);

        $responseJson = $response->json();

        $paginatedEvents = null;

        if (
            $response->ok() &&
            isset($responseJson['success']) &&
            $responseJson['success'] === true &&
            isset($responseJson['data']['events']['data']) // Ensure pagination structure exists
        ) {
            $eventsData = $responseJson['data']['events'];

            $paginatedEvents = new \Illuminate\Pagination\LengthAwarePaginator(
                $eventsData['data'],
                $eventsData['total'],
                $eventsData['per_page'],
                $eventsData['current_page'],
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        $responseJson['data']['events'] = $paginatedEvents;

        return view('adveritiser_video_ad.video_ad_report', ['data' => $responseJson]);
    }

    public function ctaAd()
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }
        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/cta'));
        $responseJson = $response->json();
        // Check if API call is successful
        if (!empty($responseJson['success']) && $responseJson['success'] === true) {
            $record = $responseJson['data'];
        } else {
            $record = [];
        }

        return view('adveritiser_cta.index', compact('record'));
    }


    public function ctaAdReport($id)
    {
        if (session()->has('USER_DETAILS.CSV_STATUS') && (int) session('USER_DETAILS.CSV_STATUS') === 0) {
            return redirect()->route('auth.resetPassword');
        }

        $response = Http::timeout(300)
            ->withHeaders(Api::headers())
            ->asForm()
            ->get(Api::endpoint('/advertiser/cta/report/' . $id), [
                'per_page' => 10,
                'page' => request()->get('page', 1)
            ]);

        $responseJson = $response->json();

        $paginatedEvents = null;

        if (
            $response->ok() &&
            isset($responseJson['success']) &&
            $responseJson['success'] === true &&
            isset($responseJson['data']['events']['data']) // Ensure pagination structure exists
        ) {
            $eventsData = $responseJson['data']['events'];

            $paginatedEvents = new \Illuminate\Pagination\LengthAwarePaginator(
                $eventsData['data'],
                $eventsData['total'],
                $eventsData['per_page'],
                $eventsData['current_page'],
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        $responseJson['data']['events'] = $paginatedEvents;


        return view('adveritiser_cta.cta_report', ['data' => $responseJson]);
    }
}
