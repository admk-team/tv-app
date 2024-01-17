<section class="sliders topSlider gridSection pt-4">
    <style type="">
        .col-xl-3 {
            float: left;
        }
    </style>
    <div class="slider-container">
        <div class="listing_box allVideosBox">
            <div class="col-md-12">
                <div class="list_heading">
                    <h1>{{ \App\Services\AppConfig::getMenuBySlug($slug)?->menu_title }}</h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="innerAlVidBox">

                    @foreach (($data?->app?->genres ?? []) as $genre)
                        <div class="resposnive_Box">
                            <a href="{{ route('category', $genre->code) }}?type=genre">
                                <div class="thumbnail_img">
                                    <img src="{{ $genre->image }}"
                                        alt="{{ $genre->title }}">
                                    <div class="detail_box_hide">
                                        <div class="deta_box">
                                            <div class="content_title">{{ $genre->title }}</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>