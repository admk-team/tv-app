@extends('layouts.app')

@section('content')
    @include('components.page-slider')

    @foreach ($data->app->categories as $category)
        @if (!empty($category->streams))
        <div class="cat-slider">
            <h2 class="title">{{ $category->cat_title }}</h2>
            <div class="owl-carousel cat-owl-slider">
                @foreach ($category->streams as $stream)
                <div class="cat-slider-item">
                    <img class="cover" alt="{{ $stream->stream_title ?? '' }}" src="{{ $stream->stream_poster }}" alt="">
                    <div class="text-box">
                        <div class="text">
                            <h2>{{ $stream->stream_title ?? '' }}</h2>
                            <p>{{ $stream->stream_description ?? '' }}</p>
                            <div class="duration">{{ $stream->stream_duration_timeformat ?? '' }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.page-owl-slider').owlCarousel({
                center: true,
                items: 1,
                loop: true,
                smartSpeed: 800,
                autoplay: true,
                margin: 10,
                stagePadding: 100,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        stagePadding: 0,
                        nav: false,
                    },
                    600: {
                        stagePadding: 0,
                        nav: false,
                    },
                    1000: {
                        stagePadding: 100,
                        nav: true,
                        margin: 20,
                    }
                }
            });
        });

        $(".cat-owl-slider").owlCarousel({
                loop: false,
                rewind: true,
                smartSpeed: 800,
                autoplay: true,
                margin: 15,
                stagePadding: 100,
                nav: true,
                dots: false,
                items: 5,
                responsive: {
                    0: {
                        stagePadding: 0,
                        nav: false,
                        items: 1.4,
                    },
                    500: {
                        stagePadding: 0,
                        nav: false,
                        items: 2,
                    },
                    700: {
                        stagePadding: 0,
                        nav: false,
                        items: 3,
                    },
                    1000: {
                        stagePadding: 100,
                        nav: true,
                        margin: 20,
                        items: 3,
                    },
                    1600: {
                        stagePadding: 100,
                        nav: true,
                        margin: 20,
                        items: 5,
                    },
                }
            });


        function handleSliderControlls(e) {
            let type = $(e).data("type");
            let owlWrapper = $(e).parent();
            let prevBtn = $(owlWrapper).find(".owl-prev:eq(0)");
            let nextBtn = $(owlWrapper).find(".owl-next:eq(0)");

            if (type == 0) {
                $(prevBtn).click();
            } else {
                $(nextBtn).click();
            }
        }
    </script>
@endpush
