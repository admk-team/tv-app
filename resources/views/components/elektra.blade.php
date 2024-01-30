<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data->app->app_info->title ?? '' }}</title>
    <link rel="icon" href="{{ $data->app->app_info->website_faviocn ?? '' }}">

    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/netflix/css/netflix.css') }}">
</head>

<body>
    <div class="our_storycard">

        <div class="content_bgsnew"><img src="{{ asset('assets/landing_theme_assets/netflix/images/backs.jpg') }}">
            <div class="concord_gradient"></div>
        </div>

        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal text-white">{{ $appName }}</h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-white" href="javascript:void(0);">Support</a>
            </nav>
            <a class="btn btn-danger" href="/signup">Signup</a>
        </div>

        <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
            <div class="col-md-8 p-lg-8 mx-auto my-8">
                <h1 class="display-4 unlimmited_headers">Unlimited movies, TV shows and more.</h1>
                <p class="lead cards_headtitles">Watch anywhere. Cancel anytime.</p>
                <p class="leadinsttiltes">Ready to watch? Enter your email to create or restart your membership.</p>
                <div class="input-group is-invalid">
                    <div class="custom-file customins">
                        <input type="text" class="form-control form_inputsss" placeholder="Email Address">
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-danger btn_dangin">Get Started</button>
                    </div>
                </div>
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-7">
                <div class="leftinbox">
                    <div class="leftinpars">
                        <h1>Watch on your TV</h1>
                        <p>Unlimited Movies, TV Series on your TV, Phone, Tablet and Computer.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                <div class="rightinpars">

                    <img src="{{ asset('assets/landing_theme_assets/netflix/images/tv.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- End of first row box -->
    <div class="our_storycard"></div>
    <!-- Start of first row box -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="rightinpars">

                    <img src="{{ asset('assets/landing_theme_assets/netflix/images/mobiless.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="leftinbox">
                    <div class="leftinpars">
                        <h1>Watch Anytime, Anywhere.</h1>
                        <p>Save on your favorites to watch later. Resume where you stop watching. Download the App
                            today!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of first row box -->
    <div class="our_storycard"></div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-7">
                <div class="leftinbox">
                    <div class="leftinpars">
                        <h1>Watch everywhere.</h1>
                        <p>Unlimited movies, TV series on Roku TV, FireTV, Tizen and Apple. For download click on below
                            buttons.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-5">
                <div class="rightinpars">

                    <img src="{{ asset('assets/landing_theme_assets/netflix/images/device-pile-in.png') }}"
                        alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Start of first row box -->
    <div class="our_storycard"></div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <div class="rightinpars">

                    <img src="{{ asset('assets/landing_theme_assets/netflix/images/childrensnew.png') }}"
                        alt="">
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="leftinbox">
                    <div class="leftinpars">
                        <h1>Hundreds of Movies & Shows for Kids</h1>
                        <p>Kids can watch unlimited movies and shows anywhere at anytime. Download our app and start
                            watching.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of first row box -->

    <div class="our_storycard"></div>

    <!-- Start of first row box -->
    <div class="accrodingin">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button faq_question collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        What is {{ $appName }}? <svg id="thin-x" viewBox="0 0 26 26"
                            class="svg-icon svg-icon-thin-x svg-closed" focusable="true">
                            <path
                                d="M10.5 9.3L1.8 0.5 0.5 1.8 9.3 10.5 0.5 19.3 1.8 20.5 10.5 11.8 19.3 20.5 20.5 19.3 11.8 10.5 20.5 1.8 19.3 0.5 10.5 9.3Z">
                            </path>
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body acrodinbibody">With {{ $appName }}, you can watch thousands of
                        Movies, TV Series and Children content from your Mobile App, TV App, Tablet or PC</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button faq_question collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        How much does it cost? <svg id="thin-x" viewBox="0 0 26 26"
                            class="svg-icon svg-icon-thin-x svg-closed" focusable="true">
                            <path
                                d="M10.5 9.3L1.8 0.5 0.5 1.8 9.3 10.5 0.5 19.3 1.8 20.5 10.5 11.8 19.3 20.5 20.5 19.3 11.8 10.5 20.5 1.8 19.3 0.5 10.5 9.3Z">
                            </path>
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body acrodinbibody">{{ $appName }} Only Cost $6.99 a month or $69 a
                        year
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button faq_question collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                        aria-controls="flush-collapseThree">
                        Can I cancel? <svg id="thin-x" viewBox="0 0 26 26"
                            class="svg-icon svg-icon-thin-x svg-closed" focusable="true">
                            <path
                                d="M10.5 9.3L1.8 0.5 0.5 1.8 9.3 10.5 0.5 19.3 1.8 20.5 10.5 11.8 19.3 20.5 20.5 19.3 11.8 10.5 20.5 1.8 19.3 0.5 10.5 9.3Z">
                            </path>
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse"
                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body acrodinbibody">You can try it and cancel anytime.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
        <div class="col-md-8 p-lg-8 mx-auto my-8">
            <p class="leadinsttiltes">Ready to watch? Enter your email to create or restart your membership.</p>

            <div class="input-group is-invalid">
                <div class="custom-file customins">
                    <input type="text" class="form-control form_inputsss" placeholder="Email Address">
                </div>
                <div class="input-group-append">
                    <button class="btn btn-danger btn_dangin">Get Started</button>
                </div>
            </div>
        </div>
    </div>
    <div class="our_storycard"></div>

    <!-- Start of first row box -->
    <div class="accrodingin">
        <div class="row">
            <p class="demonsson">Questions? Call 000-800-919-1694</p>
        </div>
        <div class="row">
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footerinlinst">
                    <li><a href="javascript:void(0);">FAQ</a></li>
                    <li><a href="javascript:void(0);">Investor Relations</a></li>
                    <li><a href="javascript:void(0);">Privacy</a></li>
                    <li><a href="javascript:void(0);">Speed Test</a></li>
                </ul>
            </div>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
