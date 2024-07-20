<style>
    /* .background_section {
               position: relative;
               background-size: cover;
               background-position: center;
               background-repeat: no-repeat;
               height: 50vh;
               color: #fff;
           } */
.background_section {
    position: relative;
    background-size: 100% auto;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100vh;
    color: #fff;
}


    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
    }
</style>
<div class="content">
    <section class="show_box">
        <div class="container-fluid add_box">
            @php
                $imageURL = $data->app->app_info->website_homescrn_poster ?? '';
            @endphp
            <div class="background_section" style="background-image: url('{{ $imageURL }}')">
                <div class="overlay centered_content">
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
            </div>
        </div>
    </section>
</div>
