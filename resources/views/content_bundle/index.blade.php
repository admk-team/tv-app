@extends('layouts.app')

@section('head')
    <style>
        :root {
            --bgcolor: {{ \App\Services\AppConfig::get()->app->website_colors->bgcolor }};
            --themeActiveColor: {{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }};
            --headerBgColor: {{ \App\Services\AppConfig::get()->app->website_colors->headerBgColor }};
            --themePrimaryTxtColor: {{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }};
            --themeSecondaryTxtColor: {{ \App\Services\AppConfig::get()->app->website_colors->themeSecondaryTxtColor }};
            --navbarMenucolor: {{ \App\Services\AppConfig::get()->app->website_colors->navbarMenucolor }};
            --navbarSearchColor: {{ \App\Services\AppConfig::get()->app->website_colors->navbarSearchColor }};
            --footerbtmBgcolor: {{ \App\Services\AppConfig::get()->app->website_colors->footerbtmBgcolor }};
            --slidercardBgColor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardBgColor }};
            --slidercardTitlecolor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardTitlecolor }};
            --slidercardCatColor: {{ \App\Services\AppConfig::get()->app->website_colors->slidercardCatColor }};
            --cardDesColor: {{ \App\Services\AppConfig::get()->app->website_colors->cardDesColor }};
        }

        .theme_bg_color {
            background-color: var(--themeActiveColor) !important;
        }

        .bg_color {
            color: var(--bgcolor) !important;
        }

        .theme_color {
            color: var(--themeActiveColor) !important;
        }

        .primray_color {
            color: var(--themePrimaryTxtColor) !important;
        }
    </style>
@endsection
@section('content')
    <div class="container my-5">
        <!-- Title and Description -->
        <div class="mb-4 text-center">
            <h1 class="display-5 primray_color"><b>{{ $data['bundleContent']['title'] }}</b></h1>
            <p class="lead primray_color" style="font-size: 16px;">{{ $data['bundleContent']['short_description'] }}</p>
        </div>
        @if ($data['bundleContent']['status'] == 'unpaid')
            <div class="mt-5 border-top pt-4">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    <span class="text-success fw-bold fs-3 theme_color">${{ $data['bundleContent']['amount'] }}</span>
                    <form action="{{ route('bundle.purchase') }}" method="POST">
                        @csrf
                        <!-- Bundle Content Details -->
                        <input type="hidden" name="bundleContent[amount]" value="{{ $data['bundleContent']['amount'] }}">
                        <input type="hidden" name="bundleContent[code]" value="{{ $data['bundleContent']['code'] }}">
                        <input type="hidden" name="bundleContent[title]" value="{{ $data['bundleContent']['title'] }}">
                        <input type="hidden" name="bundleContent[description]"
                            value="{{ $data['bundleContent']['short_description'] }}">

                        @foreach ($data['relatedStreams'] as $index => $stream)
                            <input type="hidden" name="relatedStreams[{{ $index }}][title]"
                                value="{{ $stream['title'] }}">
                            <input type="hidden" name="relatedStreams[{{ $index }}][poster]"
                                value="{{ $stream['poster'] }}">
                        @endforeach

                        <button type="submit"
                            class="fw-bold fs-5 primary_color text-decoration-none theme_bg_color p-2 rounded">
                            Buy Now
                        </button>
                    </form>
                </div>
            </div>
        @else
            @php
                $bundleCode = $data['bundleContent']['code'];
            @endphp
            <div class="d-flex justify-content-end align-items-center gap-3 button_groupbox">
                <a href="{{ url("playerscreen/{$bundleCode}") }}" class="app-primary-btn rounded"><i class="fa fa-play"
                        style="margin-right: 8px"></i>Play Bundle
                </a>
            </div>
        @endif

        <!-- Streams Section -->
        <div class="row g-3 pt-4">
            @foreach ($data['relatedStreams'] as $stream)
                <div class="col-md-6">
                    <a href="{{ url("detailscreen/{$stream['code']}") }}"class="text-decoration-none">
                        <div class="card primary_color h-100">
                            <div class="row g-0 px-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-center p-2">
                                    <img src="{{ $stream['poster'] }}" class="img-fluid rounded" alt="Stream 1 Image">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="card-title p-2">
                                            <h5 class="bg_color">{{ $stream['title'] }}</h5>
                                            <div class="d-flex align-items-center justify-content-start">
                                                @if ($stream['duration'])
                                                    <p class="bg_color theme_bg_color px-2 py-1 rounded fs-bold mx-1 my-2"
                                                        style="font-size: 12px;">
                                                        <b>{{ $stream['duration'] }}</b>
                                                    </p>
                                                @endif
                                                @if ($stream['language'])
                                                    <p class="bg_color theme_bg_color px-2 py-1 rounded fs-bold mx-1 my-2"
                                                        style="font-size: 12px;">
                                                        <b>{{ collect($stream['language'])->pluck('title')->join(', ') }}</b>
                                                    </p>
                                                @endif
                                                @if ($stream['ratings'])
                                                    <p class="bg_color theme_bg_color px-2 py-1 rounded fs-bold mx-1 my-2"
                                                        style="font-size: 12px;">
                                                        <b>{{ collect($stream['ratings'])->pluck('title')->join(', ') }}</b>
                                                    </p>
                                                @endif
                                                @if ($stream['qualities'])
                                                    <p class="bg_color theme_bg_color px-2 py-1 rounded fs-bold mx-1 my-2"
                                                        style="font-size: 12px;">
                                                        <b>{{ collect($stream['qualities'])->pluck('title')->join(', ') }}</b>
                                                    </p>
                                                @endif
                                            </div>
                                            @if ($stream['genre'])
                                            <div class="d-flex align-items-center justify-content-start">
                                                <p class="bg_color theme_bg_color px-2 py-1 rounded fs-bold mx-1 my-2"
                                                    style="font-size: 12px;">
                                                    <b>{{ collect($stream['genre'])->pluck('title')->join(', ') }}</b>
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                        <p class="card-text bg_color p-2" style="font-size: 12px;">
                                            {{ \Illuminate\Support\Str::of($stream['short_description'])->words(40, '...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach


        </div>
    </div>
@endsection
