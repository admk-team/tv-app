<style>
    .text_above_image {
        text-align: center;
    }

    .text_content {
        margin-bottom: 20px;
        z-index: 99;
    }

    .cover-image {
        width: 100%;
        height: 100%;
        object-fit: none;
    }
</style>
<div class="content">
    <section class="show_box">
        <div class="container add_box">
            <div class="row">
                <div class="col-md-12">
                    <div class="text_above_image">
                        <div class="text_content">
                            <h1 class="text-white">Enjoy on your TV and Mobile</h1>
                            <p class="text-white">Unlimited stream,
                                movies and TV shows on OTT Platforms.</p>
                            <div class="about_add"><span>Watch Now:</span><span class="roku"><img
                                        src="https://24flix.tv/assets/images/roku_icon.png" alt="Roku"></span><span
                                    class="fire_tv"><img src="https://24flix.tv/assets/images/firetv_icon.png"
                                        alt="Fire TV"></span><span class="fire_tv"><img
                                        src="https://24flix.tv/assets/images/appletv.png" alt="Apple TV"></span><span
                                    class="fire_tv"><img src="https://24flix.tv/assets/images/tizenapp.png"
                                        alt="Tizen"></span></div><a href="/download-apps"><button
                                    class="detail_btn w-25"><i class="fa fa-download"></i>Download Apps</button></a>
                        </div>
                        <div class="image_content" style="height: 50vh; overflow: hidden;">
                            <img src="{{ $data->app->app_info->website_homescrn_poster ?? '' }}" alt="Feature Image" class="cover-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
