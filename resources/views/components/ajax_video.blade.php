<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('assets/landing_theme_assets/mean/css/style.css') }}">

<!-- font -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
    integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
    rel="stylesheet">

<section>
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="bg-crimsonblack">
                    <video autoplay playsinline muted loop>
                        <!-- <source src="homepage-video.webm" type="video/webm"> -->
                        <source src="<?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_video_url']; ?>" type="video/mp4">
                    </video>
                    <div class="carousel-caption">
                        <h4><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_video_title']; ?></h4>
                        <p style="display:none;">
                            Stay Healthy and Fit with a variety of fitness classes
                        </p>
                        <a class="btn btn-primary px-4" href="<?php echo HTTP_PATH; ?>/signup">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> -->
    </div>
</section>
<!-- Main Slider Section End -->
<section class="bg-black our-story-card">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="fw-bold text-white"><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_tv_section_title']; ?></h3>
                <h4 class="text-white"><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_tv_section_sub_title']; ?>
                </h4>
            </div>
            <div class="col-md-6">
                <div class="position-relative">
                    <img src="landing_theme_assets/mean/images/tv.png" class="img-fluid">
                    <img src="<?php echo $ASSETS_PATH; ?><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_tv_section_poster']; ?>" class="img-fluid tv-image">

                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-black our-story-card">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <div class="position-relative">
                    <img src="<?php echo $ASSETS_PATH; ?><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_mob_section_poster']; ?>" class="img-fluid">
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold text-white"><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_mob_section_title']; ?></h3>
                <h4 class="text-white"><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_mob_section_sub_title']; ?></h4>
            </div>
        </div>
    </div>
</section>
<section class="bg-black our-story-card">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h3 class="fw-bold text-white"><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_dnld_section_title']; ?></h3>
                <h4 class="text-white"><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_dnld_section_sub_title']; ?></h4>

                <ul class="list-unstyled d-flex flex-wrap fs-5 text-secondary mt-3">
                    <li>Watch Now: </li>
                    <li><img src="landing_theme_assets/mean/images/roku_icon.png" width="50"> </li>
                    <li><img src="landing_theme_assets/mean/images/firetv_icon.png" width="50"></li>
                    <li><img src="landing_theme_assets/mean/images/appletv.png" width="50"></li>
                    <li><img src="landing_theme_assets/mean/images/tizenapp.png" width="50"></li>
                </ul>
                <button class="btn btn-primary">Download Now</button>
            </div>
            <div class="col-md-6">
                <div class="position-relative">
                    <img src="<?php echo $ASSETS_PATH; ?><?php echo $WEBSITE_BRANDING_KEYS['ajax_video_theme_dnld_section_poster']; ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-black our-story-card" style="display:none;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-5">Frequently Asked Questions</h1>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fs-5 fw-bold" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                What is hadassah TV?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in felis
                                dignissim, imperdiet nulla vitae, condimentum nulla. Ut scelerisque a nisl sit amet
                                facilisis. Etiam blandit iaculis tellus, vitae condimentum leo congue a. Vivamus in
                                vehicula massa. Pellentesque libero libero, commodo lacinia volutpat non, tincidunt
                                at lectus. Maecenas ipsum turpis, viverra vitae lacus eu, fringilla ultricies erat.
                                Aenean hendrerit maximus sodales.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fs-5 fw-bold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                aria-controls="collapseTwo">
                                Where can i watch?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Quisque sapien augue, ornare id leo a, tristique elementum justo. Praesent non nulla
                                sagittis, sollicitudin justo id, varius erat. Nunc sed pharetra nisl. Cras et
                                suscipit felis, in lacinia sapien. Integer venenatis sagittis massa, eu eleifend
                                nibh venenatis in. Pellentesque a aliquet urna. Curabitur tortor metus, ultrices sed
                                mi at, sagittis imperdiet turpis. Suspendisse nec luctus nunc. Fusce in arcu quis
                                lacus mollis ultrices.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fs-5 fw-bold" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                aria-controls="collapseThree">
                                How do i cancel?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Praesent nec ipsum scelerisque dui condimentum pellentesque eu at lectus. Vivamus
                                purus purus, bibendum in vestibulum ac, pharetra sit amet sapien. Nunc luctus, orci
                                vel luctus cursus, nibh nisl ullamcorper ipsum, eu malesuada arcu augue id nisi. In
                                auctor mi ac ante tincidunt tincidunt.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<div class="container">
    <div class="row justify-content-center p-4">
        <div class="col-12 col-md-8 col-xl-8 text-center">
            <h5 class="text-white mb-3">
                Ready to watch? Enter your email to create or restart your membership.
            </h5>
            <div class="input-group mb-3">
                <input type="text" class="form-control p-3" placeholder="Recipient's username"
                    aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-primary p-3" type="button" id="button-addon2">Get Started</button>
            </div>
        </div>
    </div>
</div>
