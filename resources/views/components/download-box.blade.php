<section class="show_box">
    <div class="container-fluid add_box">
        <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="left_side_box">
            <div class="about_site">
                <h1>
                 Enjoy on your TV and Mobile
                <div class="circleins"></div>
                </h1>
                <p>Unlimited stream, movies and TV shows on OTT Platforms.</p>
                <div class="about_add">
                    <span>Watch Now:</span>
                    <span class="roku"><img src="{{ asset('assets/images/roku_icon.png') }}"></span>
                    <span class="fire_tv"><img src="{{ asset('assets/images/firetv_icon.png') }}"></span>
                    <span class="fire_tv"><img src="{{ asset('assets/images/appletv.png') }}"></span>
                    <span class="fire_tv"><img src="{{ asset('assets/images/tizenapp.png') }}"></span>
                </div>
                <div class="button_groupbox btnvsh">
                    <div class="btn_box">
                        <a href="/download-apps"><button class="detail_btn"><i class="fa fa-download"></i> Download Apps</button></a>
                    </div>
                </div>
        
            </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="right_side_box">
            <div class="add_image_box addsimg">
                <img src="{{ $data->app->app_info->website_homescrn_poster ?? '' }}" onerror="this.src='https://stage.24flix.tv/images/default_home.png';" alt="Feature Image">
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>