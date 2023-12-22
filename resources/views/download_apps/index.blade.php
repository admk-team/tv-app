@extends('layouts.app')

@section('content')
    @php
        $tvTitle = $api_data->app->colors_assets_for_branding->web_dl_page_tv_section_top_title ?? '';
        $tvDesc = $api_data->app->colors_assets_for_branding->web_dl_page_tv_section_title ?? '';
        $assetPath = $api_data->app->paths->assets_path ?? '';
        $tvImg = $api_data->app->colors_assets_for_branding->web_download_page_tv_section_poster ?? ('' ?? '');
        $mblTitle = $api_data->app->colors_assets_for_branding->web_dl_page_mob_section_top_title ?? ('' ?? '');
        $mblDesc = $api_data->app->colors_assets_for_branding->web_dl_page_mob_section_title ?? ('' ?? '');
        $mblImg = $api_data->app->colors_assets_for_branding->web_download_page_mob_section_poster ?? ('' ?? '');
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
                            <li><a href="javascript:void(0)"> <img src="{{ asset('assets/images/roku_icon.png') }}"
                                        alt=""></a></li>
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
