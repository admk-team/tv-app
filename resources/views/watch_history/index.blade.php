@extends('layouts.app')

@push('style')
    <style>
        body {
            overflow-x: hidden;
        }

        .main-div {
            height: 100% !important;
        }

        .whoIsWatching {
            padding-top: 120px;
        }

        .addIcon i {
            font-size: 7.9vw !important;
        }

        .item {
            padding: 10px;
        }
    </style>
@endpush

@section('content')
    <section class="">
        <div class="">
            <div class="listing_box" style="padding-left: 350px">
                <div class="slider_title_box">
                    <div class="list_heading">
                        <h1>Watch History</h1>
                    </div>
                </div>
                <div class="">
                    <div style="display: flex">
                        <div class="item">
                            <div class="ripple">
                                <a href="http://127.0.0.1:8000/detailscreen/f9c5c8bde8364943a7c17027a5d51205">
                                    <div class="thumbnail_img">
                                        <div class="trending_icon_box" style="display: none;"><img
                                                src="http://127.0.0.1:8000/assets/images/trending_icon.png" alt="Trending">
                                            ">
                                        </div>
                                        <div class="">
                                            <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690652617_cc1_ttw_.jpg"
                                                alt="Letters To God">
                                        </div>
                                        <div class="detail_box_hide">
                                            <div class="detailbox_time">
                                                1:50:00
                                            </div>
                                            <div class="deta_box">
                                                <div class="season_title"></div>
                                                <div class="content_title">Letters To God</div>
                                                <div class="content_description">
                                                    Tyler is an extraordinary eight-year-old boy armed with strong faith and
                                                    courage as he faces his daily battle against cancer. Surrounded by a
                                                    loving
                                                    family and community, Tyler&#039;s prayers take the form of letters he
                                                    sends
                                                    to his ultimate pen pal, God.
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                                </a>
                            </div>
                        </div>
                        <div class="content_title">Letters To God</div>
                        <div class="content_description">
                            Tyler is an extraordinary eight-year-old boy armed with strong faith and
                            courage as he faces his daily battle against cancer. Surrounded by a loving
                            family and community, Tyler&#039;s prayers take the form of letters he sends
                            to his ultimate pen pal, God.
                        </div>
                    </div>
                    <div class="item">
                        <div class="ripple">
                            <a href="http://127.0.0.1:8000/detailscreen/10f3423f11e250913780dbf0998eed7e">
                                <div class="thumbnail_img">
                                    <div class="trending_icon_box" style="display: none;"><img
                                            src="http://127.0.0.1:8000/assets/images/trending_icon.png" alt="Trending">
                                        ">
                                    </div>
                                    <div class="">
                                        <img src="https://onlinechannel.io/storage/1676458919_1509cc4_wI99iDaFT81G1J0eu67w1Ycf8uzeHcORluMNJPEKeLY.png"
                                            alt="Super Detention">
                                    </div>
                                    <div class="detail_box_hide">
                                        <div class="detailbox_time">
                                            1:24:00
                                        </div>
                                        <div class="deta_box">
                                            <div class="season_title"></div>
                                            <div class="content_title">Super Detention</div>
                                            <div class="content_description">
                                                Five misfit superhero teens have to work together to save the school from an
                                                evil villain trying to steal all the student&#039;s powers.
                                            </div>


                                            <div
                                                style="background-color:#555455;height:5px; border-radius:2px;margin-top:10px;">
                                                <div
                                                    style="background-color:#07659E;height:5px;border-radius:2px;width:21.11%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
