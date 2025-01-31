@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />
    {{-- <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" /> --}}
    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-youtube@2.6.1/dist/Youtube.min.js"></script>
@endpush
<section class="sliders">
    <div class="slider-container">
        @foreach ($data->app->categories ?? [] as $category)
            @if (!empty($category->streams))
                @if (isset($category->for_group_user) && $category->for_group_user == 1)
                    @if (session()->has('USER_DETAILS.GROUP_USER') && session('USER_DETAILS.GROUP_USER') == 1)
                        @include('components.include_file_cat_slider')
                    @endif
                @else
                    @include('components.include_file_cat_slider')
                @endif
            @endif
        @endforeach
    </div>
</section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Check if the user is on a mobile device
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                return;
            }
            const videoLinks = document.querySelectorAll('.video-link');


            videoLinks.forEach((link, index) => {
                const video = link.querySelector('.card-video-js');
                if (!video) {
                    // console.error(`Video element not found for link ${index}:`, link);
                    return;
                }

                // Check if the video is already initialized
                if (videojs.getPlayer(video.id)) {
                    // console.log(`Player ${index} (${video.id}) is already initialized.`);
                    return;
                }

                const player = videojs(video.id, {
                    muted: false,
                    preload: 'auto',
                });

                player.ready(() => {

                    link.addEventListener('mouseenter', () => {
                        player.pause();
                        player.muted(false);
                        player.currentTime(0);
                        player.play().then(() => {}).catch((error) => {
                            // console.error(`Error playing video ${index}:`, error);
                        });
                    });

                    link.addEventListener('mouseleave', () => {
                        player.muted(true);
                        player.pause();
                        player.currentTime(0);
                    });
                });
            });
        });
    </script>
@endpush
