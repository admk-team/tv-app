@if (isset($data->app->app_info->faq_section) && $data->app->app_info->faq_section == 1)
    <!-- START: FAQ Section -->
    <!-- Start FAQ-->
    @if (isset($data->app->landingpages) &&
            array_reduce(
                $data->app->landingpages,
                fn($carry, $item) => $carry || ($item->section_type === 'faq' && $item->page_type === 'default'),
                false))
        <div class="d-flex align-items-center text-center justify-content-center mb-3">
            <div class="leftinpars sec-device">
                <h1>Frequently Asked <span>Questions</span></h1>
            </div>
        </div>
        <div class="row justify-content-center mb-5 mt-3" style="max-width: 100%;">
            @foreach ($data->app->landingpages as $index => $page)
                @if ($page->page_type === 'default' && $page->section_type === 'faq' && $page->status === 1)
                    <div class="col-sm-12 col-md-8 col-lg-8 text-center">
                        <div class="accrodingin">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne{{ $index }}">
                                        <button class="accordion-button faq_question collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{ $index }}"
                                            aria-expanded="false" aria-controls="flush-collapseOne{{ $index }}">
                                            {{ $page->title ?? '' }}
                                            <svg id="thin-x" viewBox="0 0 26 26"
                                                class="svg-icon svg-icon-thin-x svg-closed" focusable="true">
                                                <path
                                                    d="M10.5 9.3L1.8 0.5 0.5 1.8 9.3 10.5 0.5 19.3 1.8 20.5 10.5 11.8 19.3 20.5 20.5 19.3 11.8 10.5 20.5 1.8 19.3 0.5 10.5 9.3Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne{{ $index }}" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne{{ $index }}" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body acrodinbibody">{{ $page->description ?? '' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>        
    @endif
@endif

<!-- END: FAQ Section -->
