  <style>
      .overlapping_layout {
          position: relative;
      }

      .text_area {
          position: absolute;
          top: 0;
          left: 0;
          background-image: linear-gradient(rgba(255, 255, 255, 0.4),
                  var(--bgcolor) 100%,
                  rgb(246, 246, 246) 15%);
          color: #fff;
          padding: 20px;
          z-index: 10;
          max-width: 40%;
          height: 100%;
          display: flex;
          align-items: start;
          justify-content: center;
          flex-direction: column;
      }

      .image_area {
          width: 100%;
          height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
          overflow: hidden;
          position: relative;
      }

      .image_area img {
          position: absolute;
          top: 50%;
          left: 50%;
          width: 100%;
          /* Ensures full width */
          height: auto;
          /* Maintains aspect ratio */
          transform: translate(-50%, -50%);
          /* Centers the image */
      }

      .text-white-custom {
          color: var(--themePrimaryTxtColor)
      }
  </style>

  <div class="content">
      <section class="show_box">
          <div class="container-fluid add_box">
              <div class="row">
                  <div class="col-md-12 overlapping_layout">
                      <div class="text_area">
                          <h1 class="text-white-custom">Enjoy on your TV and Mobile</h1>
                          <p class="text-white-custom">Unlimited stream, movies and TV shows on OTT Platforms.</p>
                          <div class="about_add">
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
                          <a href="/download-apps"><button class="detail_btn"><i class="fa fa-download"></i> Download
                                  Apps</button></a>
                      </div>
                      <div class="image_area">
                          <img src="{{ \App\Services\AppConfig::get()->app->app_info->website_homescrn_poster ?? '' }}"
                              alt="Feature Image">
                      </div>
                  </div>
              </div>
          </div>
      </section>
  </div>
