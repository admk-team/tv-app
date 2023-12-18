@extends('layouts.app')

@section('content')

    @include('components.page-banner')
    @include('components.category-slider')

    @if ($slug == 'home')
        @include('components.download-box')
    @endif
    
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

            $('.cat-slick-slider').slick({
                dots: false,
                infinite: true,
                loop: true,
                // autoplay: true,
                // autoplaySpeed: 3000,
                slidesToShow: 5,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1740,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            dots: true,
                            arrows: true
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            dots: true,
                            arrows: false
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            arrows: false
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            dots: false,
                            arrows: false,
                        }
                    }
                ]
            });
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
