@extends('layouts.app')

@section('content')
    <section class="sliders topSlider gridSection"
        style="background: url(https://admk.24flix.tv/images/oops.gif) no-repeat; background-size: cover; background-position:center;height: 100vh;">
        <div class="container">
            <div class="row align-items-center justify-content-center pt-5 hts-100">
                <div class="error-set">
                    <div class="text-white text-center" style="font-size: 10rem; font-weight: 600; line-height: 1em;">
                        <span class="fs-1">⏳</span>
                    </div>
                    <div class="text-white text-center fs-2">
                        This Watch Party Hasn't Started Yet
                    </div>
                    <div class="text-white text-center">
                        The event will begin at {{ $startDateTime->format('Y-m-d H:i') }}.
                    </div>
                    <div class="text-white text-center mt-4">
                        Please check back when the event starts.
                    </div>
                    <div class="text-white text-center mt-4">
                        <div id="countdown"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var startDateTime = '{{ $startDateTime->format('Y-m-d H:i') }}';
        var startDate = new Date(startDateTime + ' UTC');

        function updateCountdown() {
            var currentTime = new Date();
            var timeDifference = startDate - currentTime;

            if (timeDifference <= 0) {
                location.reload();
            } else {
                var seconds = Math.floor(timeDifference / 1000);
                var minutes = Math.floor(seconds / 60);
                var hours = Math.floor(minutes / 60);
                minutes = minutes % 60;
                seconds = seconds % 60;
                document.getElementById('countdown').textContent = hours + "h " + minutes + "m " + seconds + "s";
            }
        }

        setInterval(updateCountdown, 1000);
    </script>
@endsection
