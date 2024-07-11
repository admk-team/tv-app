  <style>
      .overlapping_layout {
          position: relative;
      }

      .text_area {
          position: absolute;
          top: 0;
          left: 0;
          background: rgba(0, 0, 0, 0.7);
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
          height: 50vh;
          overflow: hidden;
      }

      .image_area img {
          width: 100%;
          height: 100%;
          object-fit: cover;
      }
  </style>

  <div class="content">
      <section class="show_box">
          <div class="container-fluid add_box">
              <div class="row">
                  <div class="col-md-12 overlapping_layout">
                      <div class="text_area">
                          <h1>Enjoy on your TV and Mobile</h1>
                          <p>Unlimited stream, movies and TV shows on OTT Platforms.</p>
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
                <img src="{{ $data->app->app_info->website_homescrn_poster ?? '' }}"  alt="Feature Image">
                      </div>
                  </div>
              </div>
          </div>
      </section>
  </div>
