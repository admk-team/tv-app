@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cards-item.css') }}" />
    <link href="https://vjs.zencdn.net/7.15.4/video-js.css" rel="stylesheet">
    <style>
        .skeleton {
            background: linear-gradient(90deg, #4d4d4e 25%, #4d4d4e 50%, #4d4d4e 75%);
            background-size: 200% 100%;
            border-radius: 10px;
            animation: shimmer 1.5s infinite;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
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
            overflow-x: auto;
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
                        <div class="category-wrapper" data-cat-guid="{{ $category->cat_guid }}" data-cat-title="{{ $category->cat_title }}">
                            <!-- Skeleton Loader -->
                            <div class="skeleton-loader">
                                <div class="skeleton skeleton-title"></div>
                                <div class="skeleton-slider">
                                    @for ($i = 0; $i < 7; $i++)
                                        <div class="skeleton skeleton-item"></div>
                                    @endfor
                                </div>
                            </div>
                            <!-- Actual Content (Hidden Initially) -->
                            <div class="slider-container hidden">
                                @include('components.include_file_cat_slider')
                            </div>
                        </div>
                    @endif
                @endif
            @else
                <div class="category-wrapper" data-cat-guid="{{ $category->cat_guid }}" data-cat-title="{{ $category->cat_title }}"
                    data-cat-type="{{ $category->cat_type }}">
                    <!-- Skeleton Loader -->
                    <div class="skeleton-loader">
                        <div class="skeleton skeleton-title"></div>
                        <div class="skeleton-slider">
                            @for ($i = 0; $i < 7; $i++)
                                <div class="skeleton skeleton-item"></div>
                            @endfor
                        </div>
                    </div>
                    <!-- Actual Content (Hidden Initially) -->
                    <div class="slider-container hidden">
                        @include('components.include_file_cat_slider')
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>

@push('scripts')
    <script src="https://vjs.zencdn.net/7.20.3/video.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/videojs-youtube@2.6.1/dist/Youtube.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Fetch streams for each category via AJAX
            const categoryWrappers = document.querySelectorAll('.category-wrapper');
            categoryWrappers.forEach(wrapper => {
                const catGuid = wrapper.dataset.catGuid;
                const catTitle = wrapper.dataset.catTitle;
                const catType = wrapper.dataset.catType;

                // Make AJAX call with cat_guid and cat_title in request body
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
                    // Hide skeleton loader
                    const skeletonLoader = wrapper.querySelector('.skeleton-loader');
                    skeletonLoader.style.display = 'none';

                    // Check if streams are empty
                    if (!data.success || !data.data.streams || data.data.streams.length === 0) {
                        // Hide the entire category wrapper if no streams
                        wrapper.classList.add('hidden');
                        return;
                    }

                    // Show content
                    const sliderContainer = wrapper.querySelector('.slider-container');
                    sliderContainer.classList.remove('hidden');

                    // Update category title
                    const titleElement = sliderContainer.querySelector('.list_heading h1');
                    if (titleElement) {
                        titleElement.textContent = catTitle;
                    }

                    // Initialize Video.js players
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
                                player.play().catch(error => {});
                            });

                            link.addEventListener('mouseleave', () => {
                                player.muted(true);
                                player.pause();
                                player.currentTime(0);
                            });
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching category streams:', error);
                    // Hide skeleton and category wrapper on error
                    const skeletonLoader = wrapper.querySelector('.skeleton-loader');
                    skeletonLoader.style.display = 'none';
                    wrapper.classList.add('hidden');
                });
            });
        });
    </script>
@endpush