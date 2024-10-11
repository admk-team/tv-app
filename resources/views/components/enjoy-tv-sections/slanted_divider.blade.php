<style>
    .slanted_image_box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
    }

    .slanted_text_box {
        background-image: linear-gradient(rgba(4, 9, 30, 0.4),
                var(--themeActiveColor) 100%,
                rgb(246, 246, 246) 15%);
        clip-path: polygon(0 25%, 100% 0, 100% 100%, 0 100%);
        padding: 4rem 0;
    }
</style>
<div class="content">
    <section class="show_box">
        <div class="container add_box">
            <div class="row">
                <div class="col-md-6 p-0">
                    <div class="slanted_image_box">
                        <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_homescrn_poster ?? '' }}"
                            alt="Feature Image" class="cover-image">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center slanted_text_box">
                    <div class="about_site text-center">
                        <h1>Enjoy on your TV and Mobile</h1>
                        <p>Unlimited stream, movies and TV shows on OTT Platforms.</p>
                        <div class="about_add mb-3">
                            <span>Watch Now:</span>
                            <span class="roku"><img src="https://24flix.tv/assets/images/roku_icon.png"
                                    alt="Roku"></span>
                            <span class="fire_tv"><img src="https://24flix.tv/assets/images/firetv_icon.png"
                                    alt="Fire TV"></span>
                            <span class="fire_tv"><img src="https://24flix.tv/assets/images/appletv.png"
                                    alt="Apple TV"></span>
                            <span class="fire_tv"><img src="https://24flix.tv/assets/images/tizenapp.png"
                                    alt="Tizen"></span>
                        </div>
                        <a href="/download-apps"><button class="detail_btn w-25  mb-3"><i class="fa fa-download"></i>
                                Download
                                Apps</button></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
