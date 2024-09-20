@extends('layouts.app')

@section('content')
<style>
.lds-roller,
.lds-roller div,
.lds-roller div:after {
  box-sizing: border-box;
}
.lds-roller {
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-roller div {
  animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  transform-origin: 40px 40px;
}
.lds-roller div:after {
  content: " ";
  display: block;
  position: absolute;
  width: 7.2px;
  height: 7.2px;
  border-radius: 50%;
  background: var(--themePrimaryTxtColor);
  margin: -3.6px 0 0 -3.6px;
}
.lds-roller div:nth-child(1) {
  animation-delay: -0.036s;
}
.lds-roller div:nth-child(1):after {
  top: 62.62742px;
  left: 62.62742px;
}
.lds-roller div:nth-child(2) {
  animation-delay: -0.072s;
}
.lds-roller div:nth-child(2):after {
  top: 67.71281px;
  left: 56px;
}
.lds-roller div:nth-child(3) {
  animation-delay: -0.108s;
}
.lds-roller div:nth-child(3):after {
  top: 70.90963px;
  left: 48.28221px;
}
.lds-roller div:nth-child(4) {
  animation-delay: -0.144s;
}
.lds-roller div:nth-child(4):after {
  top: 72px;
  left: 40px;
}
.lds-roller div:nth-child(5) {
  animation-delay: -0.18s;
}
.lds-roller div:nth-child(5):after {
  top: 70.90963px;
  left: 31.71779px;
}
.lds-roller div:nth-child(6) {
  animation-delay: -0.216s;
}
.lds-roller div:nth-child(6):after {
  top: 67.71281px;
  left: 24px;
}
.lds-roller div:nth-child(7) {
  animation-delay: -0.252s;
}
.lds-roller div:nth-child(7):after {
  top: 62.62742px;
  left: 17.37258px;
}
.lds-roller div:nth-child(8) {
  animation-delay: -0.288s;
}
.lds-roller div:nth-child(8):after {
  top: 56px;
  left: 12.28719px;
}
@keyframes lds-roller {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>

    <section class="sliders topSlider gridSection" style="padding-top: 38px;">
        <div class="slider-container">
            <div class="listing_box allVideosBox">
                <div class="col-md-12">
                    <form action="{{ route('search') }}">
                        <div class="searchbox rounded">
                            <input type="text" class="search_bar rounded" name="searchKeyword" id="searchKeyword" value="{{ request()->searchKeyword }}"
                                placeholder="Search" required="">
                            <span class="search_icon"><button type="submit"
                                    style="text-decoration:none;border: none;background-color: #ffffff;"><img
                                        src="https://stage.24flix.tv/images/searchs.png"></button>
                            </span>
                        </div>
                    </form>
                </div>
                {{-- <div class="col-md-12">
                    <div class="list_heading">
                        <h1>{{ $searchResult['total_rcd'] }} Records Match for this keyword "{{ $keyword }}"</h1>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="loader search-loader justify-content-center p-4" style="display: none;"><div class="d-flex justify-content-center"><div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div></div>
                    <div class="innerAlVidBox">
                        @forelse ($searchResult['streams'] as $stream)
                            <div class="resposnive_Box">
                                <a href="{{ route('detailscreen', $stream['stream_guid']) }}">
                                    <div class="thumbnail_img">
                                        <div class="trending_icon_box" style="display: none;"><img
                                                src="https://stage.24flix.tv/images/trending_icon.png"
                                                alt="A Case of Identity">
                                        </div>
                                        <img src="{{ $stream['stream_poster'] ?? '' }}" alt="A Case of Identity">
                                        <div class="detail_box_hide">
                                            <div class="detailbox_time">{{ $stream['stream_duration_timeformat'] }}</div>
                                            <div class="deta_box">
                                                <div class="season_title">{{ $stream['stream_episode_title'] && $stream['stream_episode_title'] !== 'NULL'? $stream['stream_episode_title']: '' }}</div>
                                                <div class="content_title">{{ $stream['stream_title'] }}</div>
                                                <div class="content_description">{{ $stream['stream_description'] ?? '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <h3 class="empty-search-result">No results found!</h3>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.querySelector('#searchKeyword').addEventListener('input', debounce((event) => {
        const url = event.target.closest('form').action;
        const keyword = event.target.value;
        if (keyword.length !== 0 && keyword.length < 3) {
            return;
        }

        $.ajax({
           url: `${url}?searchKeyword=${keyword}`,
           method: 'GET',
           beforeSend: function () {
            setLoader(true);
           },
           success: function (res) {
            const newHTML = $(res);
            $('.innerAlVidBox').replaceWith(newHTML.find('.innerAlVidBox'));
            setLoader(false);
           },
           error: function () {
            setLoader(false);
           }
        });
    }, 400));

    function setLoader(show = true) {
        document.querySelector('.loader').style.display = show? 'block': 'none';
        document.querySelector('.innerAlVidBox').style.display = show? 'none': 'block';
    }

    function debounce(func, delay) {
        let timeoutId;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
            func.apply(context, args);
            }, delay);
        };
    }
</script>
@endpush
