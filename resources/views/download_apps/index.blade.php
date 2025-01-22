@extends('layouts.app')

@section('content')
    @php
        $tvTitle =
            \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_dl_page_tv_section_top_title ?? '';
        $tvDesc = \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_dl_page_tv_section_title ?? '';
        $assetPath = \App\Services\AppConfig::get()->app->paths->assets_path ?? '';
        $tvImg =
            \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_download_page_tv_section_poster ??
            ('' ?? '');
        $mblTitle =
            \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_dl_page_mob_section_top_title ??
            ('' ?? '');
        $mblDesc =
            \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_dl_page_mob_section_title ??
            ('' ?? '');
        $mblImg =
            \App\Services\AppConfig::get()->app->colors_assets_for_branding->web_download_page_mob_section_poster ??
            ('' ?? '');
    @endphp

    <div class="container-fluid">
        <div class="row border_ottbtm">
            <div class="col-sm-12 col-md-7">
                <div class="left_side_box">
                    <div class="about_site">
                        <h1>
                            {{ $tvTitle }} <div class="circleins"></div>
                        </h1>
                        <p>{{ $tvDesc }}</p>
                        <ul class="ott_iconlist">
                            @if (env('APP_CODE') == '382f94988e01455c7262c1480ae530a6')
                                <li><a
                                        href="https://channelstore.roku.com/details/5b1bb4053ae3096bf2489712955ce7f3/olive-branch-tv">
                                        <img src="{{ asset('assets/images/roku_icon.png') }}" alt=""></a></li>
                            @else
                                <li><a href="javascript:void(0)"> <img src="{{ asset('assets/images/roku_icon.png') }}"
                                            alt=""></a></li>
                            @endif
                            <li><a href="javascript:void(0)"> <img src="{{ asset('assets/images/firetv_icon.png') }}"
                                        alt=""></a></li>
                            <li><a href="javascript:void(0)"> <img src="{{ asset('assets/images/appletv.png') }}"
                                        alt=""></a></li>
                            <li><a href="javascript:void(0)"> <img src="{{ asset('assets/images/tizenapp.png') }}"
                                        alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                <div class="right_side_box">
                    <div class="add_image_box">
                        <img src="{{ $assetPath . $tvImg }}" alt="OTT TV Image">
                    </div>
                </div>
            </div>
        </div>
        <div class="row border_ottbtm">
            <div class="col-sm-12 col-md-6">
                <div class="right_side_box">
                    <div class="add_image_box">
                        <img src="{{ $assetPath . $mblImg }}" alt="OTT MObile App">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="left_side_box">
                    <div class="about_site">
                        <h1>
                            {{ $mblTitle }} <div class="circleins"></div>
                        </h1>
                        <p>{{ $mblDesc }}</p>
                        <ul class="ott_iconlist">
                            <li><a href="javascript:void(0)"> <img src="{{ asset('assets/images/apple.png') }}"
                                        alt=""></a></li>
                            <li><a href="javascript:void(0)"> <img src="{{ asset('assets/images/android_mobile.png') }}"
                                        alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
