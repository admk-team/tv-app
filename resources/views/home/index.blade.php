@extends('layouts.app')

@section('content')
    @include('components.page-slider')

    <div class="cat-slider">
        <h2 class="title">Christmas & Holiday</h2>
        <div class="owl-carousel cat-owl-slider">
            <img style="width: 100%; height: 200px" src="https://stage.octv.shop/uploads/media_assets/imgs/7376d3829575f06617d9db3f7f6836df_1690623607_339_ttw_.jpg" alt="">
        </div>
    </div>
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

        $(".cat-owl-slider").owlCarousel();

        function handleSliderControlls(e) {
            let type = $(e).data("index");
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
