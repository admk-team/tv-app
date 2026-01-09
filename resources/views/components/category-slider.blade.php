@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />

    @if (isset(\App\Services\AppConfig::get()->app->toggle_trailer) &&
            \App\Services\AppConfig::get()->app->toggle_trailer == 1)
        <link href="{{ asset('assets/css/videojs-7.15.4.min.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/js/video-7.20.3.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/videojs-youtube@2.6.1/dist/Youtube.min.js"></script>
    @endif
    {{-- <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet"> --}}
    {{-- <script src="https://vjs.zencdn.net/7.20.3/video.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

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
                        <div class="category-wrapper" data-cat-guid="{{ $category->cat_guid }}"
                            data-cat-title="{{ $category->cat_title }}" data-cat-type="{{ $category->cat_type ?? '' }}"
                            data-card-type="{{ $category->card_type ?? '' }}"
                            data-is-show-view-more="{{ $category->is_show_view_more ?? 'Y' }}"
                            data-items-per-row="{{ $category->items_per_row ?? 5 }}"
                            data-is-top10="{{ $category->is_top10 ?? 'N' }}"
                            data-menu_type="{{ $category->menu_type ?? 'N' }}"
                            data-menu_guid="{{ $category->menu_guid ?? 'N' }}">
                            <!-- Skeleton Loader -->
                            <div class="skeleton-loader">
                                <div class="skeleton skeleton-title"></div>
                                <div class="skeleton-slider">
                                    @for ($i = 0; $i < 10; $i++)
                                        <div class="skeleton skeleton-item"></div>
                                    @endfor
                                </div>
                            </div>
                            <div class="slider-container hidden"></div>
                        </div>
                    @endif
                @endif
            @else
                <div class="category-wrapper" data-cat-guid="{{ $category->cat_guid }}"
                    data-cat-title="{{ $category->cat_title }}" data-cat-type="{{ $category->cat_type ?? '' }}"
                    data-card-type="{{ $category->card_type ?? '' }}"
                    data-is-show-view-more="{{ $category->is_show_view_more ?? 'Y' }}"
                    data-items-per-row="{{ $category->items_per_row ?? 5 }}"
                    data-is-top10="{{ $category->is_top10 ?? 'N' }}"
                    data-menu_type="{{ $category->menu_type ?? 'N' }}"
                    data-menu_guid="{{ $category->menu_guid ?? 'N' }}">
                    <!-- Skeleton Loader -->
                    <div class="skeleton-loader">
                        <div class="skeleton skeleton-title"></div>
                        <div class="skeleton-slider">
                            @for ($i = 0; $i < 10; $i++)
                                <div class="skeleton skeleton-item"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="slider-container hidden"></div>
                </div>
            @endif
        @endforeach
    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Function to initialize Video.js players
            function initializeVideoPlayers(videoLinks) {
                videoLinks.forEach((link, index) => {
                    const video = link.querySelector('.card-video-js');
                    if (!video) {
                        {{--  console.error(`Video element not found for link ${index}:`, link);  --}}
                        return;
                    }

                    // Validate video ID
                    if (!video.id || video.id.trim() === '' || video.id.includes('#')) {
                        {{--  console.error(`Invalid or missing video ID for link ${index}:`, video);  --}}
                        return;
                    }

                    // Check if the video is already initialized
                    if (videojs.getPlayer(video.id)) {
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
                                console.error(`Error playing video ${index}:`,
                                    error);
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

            // Initialize existing video links on page load
            const initialVideoLinks = document.querySelectorAll('.video-link');
            initializeVideoPlayers(initialVideoLinks);

            // Function to initialize Slick sliders
            function initializeSlider(container) {
                const sliderElements = jQuery(container).find('.slick-slider:not(.slick-initialized)');
                if (sliderElements.length && typeof jQuery !== 'undefined' && jQuery.fn.slick) {
                    sliderElements.each(function() {
                        const $slider = jQuery(this);
                        const itemsPerRow = parseInt($slider.data('items-per-row')) || 5;
                        const autoplay = $slider.data('autoplay') === false;

                        $slider.slick({
                            slidesToShow: itemsPerRow,
                            slidesToScroll: 1,
                            autoplay: autoplay,
                            infinite: true,
                            dots: true,
                            arrows: true,
                            adaptiveHeight: true,
                            responsive: [{
                                    breakpoint: 1740,
                                    settings: (itemsPerRow == 2) ? {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        arrows: true
                                    } : {
                                        slidesToShow: Math.max(itemsPerRow - 1, 1),
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        dots: true,
                                        arrows: true
                                    }
                                },
                                {
                                    breakpoint: 1200,
                                    settings: (itemsPerRow == 2) ? {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        arrows: false
                                    } : {
                                        slidesToShow: Math.max(itemsPerRow - 1, 1),
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        dots: true,
                                        arrows: false
                                    }
                                },
                                {
                                    breakpoint: 770,
                                    settings: (itemsPerRow == 2) ? {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        arrows: false
                                    } : {
                                        slidesToShow: Math.max(itemsPerRow - 1, 1),
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        dots: true,
                                        arrows: false
                                    }
                                },
                                {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        arrows: false
                                    }
                                },
                                {
                                    breakpoint: 480,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        swipeToSlide: true,
                                        dots: false,
                                        arrows: false
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

            // Function to force DOM reflow
            function forceReflow(element) {
                element.offsetHeight; // Accessing offsetHeight triggers a reflow
            }

            // Function to load category data
            function loadCategory(wrapper) {
                return new Promise((resolve) => {

                    const catGuid = wrapper.dataset.catGuid;
                    const catTitle = wrapper.dataset.catTitle;
                    const catType = wrapper.dataset.catType;
                    const cardType = wrapper.dataset.cardType;
                    const isShowViewMore = wrapper.dataset.isShowViewMore;
                    const itemsPerRow = wrapper.dataset.itemsPerRow;
                    const isTop10 = wrapper.dataset.isTop10;
                    const menu_guid = wrapper.dataset.menu_guid;
                    const menu_type = wrapper.dataset.menu_type;

                    // Get references to skeleton and slider container
                    const skeletonLoader = wrapper.querySelector('.skeleton-loader');
                    const sliderContainer = wrapper.querySelector('.slider-container');


                    // Prepare category object
                    const categoryData = {
                        cat_guid: catGuid,
                        cat_title: catTitle,
                        cat_type: catType,
                        card_type: cardType,
                        is_show_view_more: isShowViewMore,
                        items_per_row: parseInt(itemsPerRow),
                        is_top10: isTop10,
                        menu_guid: menu_guid,
                        menu_type: menu_type
                    };

                    // Make AJAX call to fetch streams
                    fetch('/categories/streams', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify({
                                cat_guid: catGuid,
                                cat_title: catTitle,
                                cat_type: catType,
                                menu_guid: menu_guid,
                                menu_type: menu_type,
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            resolve();
                            // Check if streams are empty
                            if (!data.success || !data.data.streams || data.data.streams.length === 0) {
                                wrapper.style.display = 'none';
                                return;
                            }

                            // Make follow-up AJAX call to render the slider component
                            fetch('/render-category-slider', {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        category: categoryData,
                                        streams: data.data.streams
                                    })
                                })
                                .then(response => response.json())
                                .then(renderData => {
                                    if (renderData.success && renderData.html) {
                                        // Use requestAnimationFrame to ensure immediate UI update
                                        requestAnimationFrame(() => {
                                            // Hide skeleton loader
                                            skeletonLoader.style.display = 'none';

                                            // Show and update the slider container with the rendered HTML
                                            sliderContainer.classList.remove('hidden');
                                            sliderContainer.innerHTML = renderData.html;

                                            // Force DOM reflow to ensure immediate rendering
                                            forceReflow(sliderContainer);

                                            // Initialize Slick Slider for the new content
                                            initializeSlider(sliderContainer);

                                            // Reinitialize Video.js players for the new content
                                            if (!/iPhone|iPad|iPod|Android/i.test(navigator
                                                    .userAgent)) {
                                                const videoLinks = sliderContainer
                                                    .querySelectorAll('.video-link');
                                                initializeVideoPlayers(videoLinks);
                                            }
                                        });
                                    } else {
                                        wrapper.style.display = 'none';
                                    }
                                })
                                .catch(error => {
                                    console.error(
                                        `Error rendering category slider for ${catTitle} (${catGuid}):`,
                                        error);
                                    wrapper.style.display = 'none';
                                });
                        })
                        .catch(error => {
                            console.error(
                                `Error fetching category streams for ${catTitle} (${catGuid}):`,
                                error);
                            wrapper.style.display = 'none';
                        });
                })
            }

            async function loadCategoryOnView(entry) {
                const wrapper = entry.target;
                if (entry.isIntersecting) {
                    observer.unobserve(wrapper); // Stop observing once loaded
                    await loadCategory(wrapper);
                }
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(loadCategoryOnView);
            }, {
                root: null, // Use the viewport
                rootMargin: '0px',
                threshold: 0.1 // Trigger when 10% of element is visible
            });

            window.onload = () => {
                const categoryWrappers = document.querySelectorAll('.category-wrapper');
                for (const wrapper of categoryWrappers) {
                    observer.observe(wrapper);
                }
            };
        });
    </script>
@endpush
