
<style>
    .about_site_design
    {
    padding: 0px 0px 0px 65px;

    }
    .text-white-custom{
      color: var(--themePrimaryTxtColor)
    }
    </style>
<div class="content">
    <section class="show_box">
      <div class="container">
        <div class="row d-flex align-items-center">
          <div class="col-md-6 col-sm-6">
            <div class="left_side_box">
              <div class="add_image_box">
                <img src="{{ $data->app->app_info->website_homescrn_poster ?? '' }}"  alt="Feature Image">
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="right_side_box">
              <div class="about_site_design">
                <h1 class="text-white-custom">
                  Enjoy on your TV and Mobile
                  <div class="circleins"></div>
                </h1>
                <p class="text-white-custom">Unlimited stream, movies and TV shows on OTT Platforms.</p>
                <div class="about_add">
                  <span>Watch Now:</span>
                  <span class="roku"><img src="https://24flix.tv/assets/images/roku_icon.png" alt="Roku"></span>
                  <span class="fire_tv"><img src="https://24flix.tv/assets/images/firetv_icon.png" alt="Fire TV"></span>
                  <span class="fire_tv"><img src="https://24flix.tv/assets/images/appletv.png" alt="Apple TV"></span>
                  <span class="fire_tv"><img src="https://24flix.tv/assets/images/tizenapp.png" alt="Tizen App"></span>
                </div>
                <div class="button_groupbox btnvsh">
                  <div class="btn_box">
                    <a href="/download-apps"><button class="detail_btn"><i class="fa fa-download"></i> Download
                        Apps</button></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
