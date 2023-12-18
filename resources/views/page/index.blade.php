@extends('layouts.app')

@section('content')
    @php
        $pages = $api_data->app->data->pages;
        $current_page_arr = array_filter($pages, function ($item) use ($slug) {
            return $item->page_slug === $slug;
        });
        $current_page = reset($current_page_arr);
    @endphp


    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="detailbox_container">
                    <div class="detailtitle">{{ $current_page->page_title ?? '' }}</div>
                    {{ $current_page->page_description ?? '' }}
                </div>
            </div>

        </div>
    </div>
@endsection
