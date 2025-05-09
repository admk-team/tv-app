@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />
    {{-- <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" /> --}}
    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-youtube@2.6.1/dist/Youtube.min.js"></script>
@endpush
<section class="sliders mb-4">
    <div class="slider-container">
        @foreach ($data->app->categories ?? [] as $category)
            @if (!empty($category->for_group_user))
                {{-- Check if the user has a group assigned in session --}}
                @if (session()->has('USER_DETAILS.GROUP_USER') && !empty(session('USER_DETAILS.GROUP_USER')))
                    @php
                        // Convert `for_group_user` to an array safely
                        $menuGroups = is_array($category->for_group_user)
                            ? array_map('intval', $category->for_group_user)
                            : (!empty($category->for_group_user)
                                ? array_map('intval', explode(',', (string) $category->for_group_user))
                                : []);

                        // Convert session `USER_DETAILS.GROUP_USER` to an array safely
                        $userGroups = is_array(session('USER_DETAILS.GROUP_USER'))
                            ? array_map('intval', session('USER_DETAILS.GROUP_USER'))
                            : (!empty(session('USER_DETAILS.GROUP_USER'))
                                ? array_map('intval', explode(',', (string) session('USER_DETAILS.GROUP_USER')))
                                : []);

                        // Find common groups
                        $commonGroups = array_intersect($menuGroups, $userGroups);
                    @endphp

                    {{-- If there's at least one common group, show the menu --}}
                    @if (!empty($commonGroups))
                        <div class="category-wrapper"
                             data-cat-guid="{{ $category->cat_guid }}"
                             data-cat-title="{{ $category->cat_title }}"
                             data-cat-type="{{ $category->cat_type }}"
                             data-card-type="{{ $category->card_type ?? '' }}"
                             data-is-show-view-more="{{ $category->is_show_view_more ?? 'Y' }}"
                             data-items-per-row="{{ $category->items_per_row ?? 5 }}"
                             data-is-top10="{{ $category->is_top10 ?? 'N' }}">
                            <div class="slider-container"></div>
                        </div>
                    @endif
                @endif
            @else
                <div class="category-wrapper"
                     data-cat-guid="{{ $category->cat_guid }}"
                     data-cat-title="{{ $category->cat_title }}"
                     data-cat-type="{{ $category->cat_type }}"
                     data-card-type="{{ $category->card_type ?? '' }}"
                     data-is-show-view-more="{{ $category->is_show_view_more ?? 'Y' }}"
                     data-items-per-row="{{ $category->items_per_row ?? 5 }}"
                     data-is-top10="{{ $category->is_top10 ?? 'N' }}">
                    <div class="slider-container"></div>
                </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Function to initialize Slick sliders only when needed
            function initializeSlider(container) {
                const sliderElements = jQuery(container).find('.slick-slider:not(.slick-initialized)');
                if (sliderElements.length && typeof jQuery !== 'undefined' && jQuery.fn.slick) {
                    sliderElements.each(function() {
                        const $slider = jQuery(this);
                        const itemsPerRow = parseInt($slider.data('items-per-row')) || 5;
                        const autoplay = $slider.data('autoplay') === false;

                        console.log('Initializing Slick Slider for:', $slider[0]);

                        $slider.slick({
                            slidesToShow: itemsPerRow,
                            slidesToScroll: 1,
                            autoplay: autoplay,
                            infinite: true,
                            dots: true,
                            arrows: true,
                            adaptiveHeight: true,
                            responsive: [
                                {
                                    breakpoint: 1024,
                                    settings: {
                                        slidesToShow: Math.min(itemsPerRow, 3),
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: Math.min(itemsPerRow, 2),
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 1,
                                    }
                                }
                            ]
                        });
                    });
                } else if (!sliderElements.length) {
                    console.log('No uninitialized sliders found in:', container);
                } else {
                    console.error('Slick Slider or jQuery not loaded for:', sliderElements);
                }
            }

            // Fetch streams for each category via AJAX
            const categoryWrappers = document.querySelectorAll('.category-wrapper');
            categoryWrappers.forEach(wrapper => {
                const catGuid = wrapper.dataset.catGuid;
                const catTitle = wrapper.dataset.catTitle;
                const catType = wrapper.dataset.catType;
                const cardType = wrapper.dataset.cardType;
                const isShowViewMore = wrapper.dataset.isShowViewMore;
                const itemsPerRow = wrapper.dataset.itemsPerRow;
                const isTop10 = wrapper.dataset.isTop10;

                // Prepare category object
                const categoryData = {
                    cat_guid: catGuid,
                    cat_title: catTitle,
                    cat_type: catType,
                    card_type: cardType,
                    is_show_view_more: isShowViewMore,
                    items_per_row: parseInt(itemsPerRow),
                    is_top10: isTop10
                };

                // Make AJAX call to fetch streams
                fetch('/categories/streams', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        cat_guid: catGuid,
                        cat_title: catTitle,
                        cat_type: catType
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Check if streams are empty
                    if (!data.success || !data.data.streams || data.data.streams.length === 0) {
                        // Hide the category wrapper if no streams
                        wrapper.style.display = 'none';
                        return;
                    }

                    // Make follow-up AJAX call to render the slider component
                    fetch('/render-category-slider', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            category: categoryData,
                            streams: data.data.streams
                        })
                    })
                    .then(response => response.json())
                    .then(renderData => {
                        if (renderData.success && renderData.html) {
                            // Update the slider container with the rendered HTML
                            const sliderContainer = wrapper.querySelector('.slider-container');
                            sliderContainer.innerHTML = renderData.html;

                            // Initialize Slick Slider for the new content
                            initializeSlider(sliderContainer);

                            // Reinitialize Video.js players for the new content
                            if (!/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
                                const videoLinks = sliderContainer.querySelectorAll('.video-link');
                                videoLinks.forEach((link, index) => {
                                    const video = link.querySelector('.card-video-js');
                                    if (!video) return;

                                    if (videojs.getPlayer(video.id)) return;

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
                            }
                        } else {
                            // Hide the category wrapper if rendering failed
                            wrapper.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error rendering category slider:', error);
                        wrapper.style.display = 'none';
                    });
                })
                .catch(error => {
                    console.error('Error fetching category streams:', error);
                    wrapper.style.display = 'none';
                });
            });
        });
    </script>
@endpush