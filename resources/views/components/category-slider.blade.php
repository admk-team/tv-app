@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />
    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-youtube@2.6.1/dist/Youtube.min.js"></script>
    <style>
        .skeleton {
            background: linear-gradient(90deg, #4b5563 25%, #6b7280 50%, #4b5563 75%);
            background-size: 200% 100%;
            border-radius: 10px;
            animation: shimmer 1.5s infinite;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .skeleton-title {
            width: 280px;
            height: 30px;
            margin-bottom: 24px;
            border-radius: 8px;
        }
        .skeleton-slider {
            display: flex;
            gap: 24px;
            overflow-x: hidden;
            white-space: nowrap;
            padding-bottom: 10px;
        }
        .skeleton-item {
            width: 240px;
            height: 150px;
            border-radius: 12px;
            flex: 0 0 auto;
        }
        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
        .slider-container.hidden {
            display: none;
        }
        .category-wrapper.hidden {
            display: none;
        }
        .skeleton-loader {
            margin-bottom: 30px;
        }
    </style>
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
                             data-cat-type="{{ $category->cat_type ?? '' }}"
                             data-card-type="{{ $category->card_type ?? '' }}"
                             data-is-show-view-more="{{ $category->is_show_view_more ?? 'Y' }}"
                             data-items-per-row="{{ $category->items_per_row ?? 5 }}"
                             data-is-top10="{{ $category->is_top10 ?? 'N' }}">
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
                <div class="category-wrapper"
                     data-cat-guid="{{ $category->cat_guid }}"
                     data-cat-title="{{ $category->cat_title }}"
                     data-cat-type="{{ $category->cat_type ?? '' }}"
                     data-card-type="{{ $category->card_type ?? '' }}"
                     data-is-show-view-more="{{ $category->is_show_view_more ?? 'Y' }}"
                     data-items-per-row="{{ $category->items_per_row ?? 5 }}"
                     data-is-top10="{{ $category->is_top10 ?? 'N' }}">
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
            // Check if the user is on a mobile device
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                return;
            }

            // Function to initialize Video.js players
            function initializeVideoPlayers(videoLinks) {
                videoLinks.forEach((link, index) => {
                    const video = link.querySelector('.card-video-js');
                    if (!video) {
                        console.error(`Video element not found for link ${index}:`, link);
                        return;
                    }

                    // Validate video ID
                    if (!video.id || video.id.trim() === '' || video.id.includes('#')) {
                        console.error(`Invalid or missing video ID for link ${index}:`, video);
                        return;
                    }

                    // Check if the video is already initialized
                    if (videojs.getPlayer(video.id)) {
                        console.log(`Player ${index} (${video.id}) is already initialized.`);
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
                                console.error(`Error playing video ${index}:`, error);
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

                        console.log('Initializing Slick Slider for:', $slider[0]);

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
                const catGuid = wrapper.dataset.catGuid;
                const catTitle = wrapper.dataset.catTitle;
                const catType = wrapper.dataset.catType;
                const cardType = wrapper.dataset.cardType;
                const isShowViewMore = wrapper.dataset.isShowViewMore;
                const itemsPerRow = wrapper.dataset.itemsPerRow;
                const isTop10 = wrapper.dataset.isTop10;
                
                // Get references to skeleton and slider container
                const skeletonLoader = wrapper.querySelector('.skeleton-loader');
                const sliderContainer = wrapper.querySelector('.slider-container');

                console.log(`Starting AJAX call for category: ${catTitle} (${catGuid})`);

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
                    console.log(`Streams fetched for category: ${catTitle} (${catGuid})`, data);

                    // Check if streams are empty
                    if (!data.success || !data.data.streams || data.data.streams.length === 0) {
                        console.log(`No streams for category: ${catTitle} (${catGuid}), hiding wrapper`);
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
                        console.log(`Slider rendered for category: ${catTitle} (${catGuid})`, renderData);

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
                                if (!/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
                                    const videoLinks = sliderContainer.querySelectorAll('.video-link');
                                    initializeVideoPlayers(videoLinks);
                                }

                                console.log(`UI updated for category: ${catTitle} (${catGuid})`);
                            });
                        } else {
                            console.log(`Render failed for category: ${catTitle} (${catGuid}), hiding wrapper`);
                            wrapper.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error(`Error rendering category slider for ${catTitle} (${catGuid}):`, error);
                        wrapper.style.display = 'none';
                    });
                })
                .catch(error => {
                    console.error(`Error fetching category streams for ${catTitle} (${catGuid}):`, error);
                    wrapper.style.display = 'none';
                });
            }

            // Load each category independently
            const categoryWrappers = document.querySelectorAll('.category-wrapper');
            categoryWrappers.forEach(wrapper => {
                loadCategory(wrapper);
            });

            console.log(`Initiated loading for ${categoryWrappers.length} categories`);
        });
    </script>
@endpush