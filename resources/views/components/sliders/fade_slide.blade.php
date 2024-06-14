@section('head')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endsection
<div class="w3-content">
    <div class="cover-slider-item">
        <div class="info">
            <h1 class="content-heading" title="Slugs &amp; Bugs">
                Slugs &amp; Bugs</h1>
            <div class="timestamp">
                <span>20 Minutes</span>
                <div class="badges">
                    <span class="badge">HD</span>
                    <span class="badge">TV-Y</span>
                </div>
            </div>
            <p class="description">
                From a producer of VeggieTales and with guests Andrew Peterson, Big Easy from the Harlem Globetrotters,
                and many more, this show is perfect for children of all ages!
            </p>
            <div class="btns">
                <a class="app-primary-btn rounded"
                    href="https://24flix.tv/playerscreen/BswPNQYfSO4yGJVMgvhrMWZOa8FHijga">
                    <i class="bi bi-play-fill banner-play-icon"></i>
                    Play
                </a>
                <a class="app-secondary-btn rounded"
                    href="https://24flix.tv/detailscreen/BswPNQYfSO4yGJVMgvhrMWZOa8FHijga">
                    <i class="bi bi-eye banner-view-icon"></i>
                    Details
                </a>
            </div>
        </div>
        <div class="cover">
            <img src="https://onlinechannel.io/storage/images/series/Slugs&amp;Bugs_2024-05-07_03-18-58.jpg"
                alt="">
        </div>
    </div>
    {{--  <img class="mySlides w3-animate-fading" src="{{ asset('assets/sliders_assets/images/action.png') }}"
        style="width:100%;display:none">  --}}
    {{--  <img class="mySlides w3-animate-fading" src="{{ asset('assets/sliders_assets/images/action1.png') }}"
        style="width:100%">

    <img class="mySlides w3-animate-fading" src="{{ asset('assets/sliders_assets/images/drama.png') }}"
        style="width:100%;display:none">
    <img class="mySlides w3-animate-fading" src="{{ asset('assets/sliders_assets/images/drama1.png') }}"
        style="width:100%;display:none">  --}}

    <div class="w3-row-padding w3-section">
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off"
                src="{{ asset('assets/sliders_assets/images/action.png') }}" style="width:100%;cursor:pointer"
                onclick="currentDiv(1)">
        </div>
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off"
                src="{{ asset('assets/sliders_assets/images/action1.png') }}" style="width:100%;cursor:pointer"
                onclick="currentDiv(2)">
        </div>
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off"
                src="{{ asset('assets/sliders_assets/images/drama.png') }}" style="width:100%;cursor:pointer"
                onclick="currentDiv(3)">
        </div>
        <div class="w3-col s3">
            <img class="demo w3-opacity w3-hover-opacity-off"
                src="{{ asset('assets/sliders_assets/images/drama1.png') }}" style="width:100%;cursor:pointer"
                onclick="currentDiv(4)">
        </div>

    </div>
</div>
@push('scripts')
    <script>
        var slideIndex = 0;
        var myIndex = 0;
        carousel();
        showDivs(slideIndex);

        function currentDiv(n) {
            clearTimeout(carouselTimeout);
            showDivs(slideIndex = n);
            carousel();
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("cover-slider-item");
            var dots = document.getElementsByClassName("demo");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
            }
            x[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " w3-opacity-off";
        }

        var carouselTimeout;

        function carousel() {
            var i;
            var x = document.getElementsByClassName("cover-slider-item");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndex++;
            if (myIndex > x.length) {
                myIndex = 1
            }
            x[myIndex - 1].style.display = "block";
            var dots = document.getElementsByClassName("demo");
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
            }
            dots[myIndex - 1].className += " w3-opacity-off";
            slideIndex = myIndex;
            carouselTimeout = setTimeout(carousel, 9000);
        }
    </script>
@endpush
