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
                        This Watch Party Has Ended
                    </div>
                    <div class="text-white text-center mt-4">
                        Thank you for attending!
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
