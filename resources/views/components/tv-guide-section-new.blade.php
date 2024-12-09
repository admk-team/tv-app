@extends('layouts.app')

@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.42/moment-timezone-with-data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/tv-guide.css') }}">
@endsection
@section('content')
    @if (isset($data->channels) && $data->channels)
        <section>
            <div class="container-fluid mt-3 mb-3">
                <div class="container">
                    <div class="row">
                        <!-- Sidebar / Navbar -->

                        <div class="col-xl-2 mt-5" style="overflow: auto; max-height:70vh;">
                            <div class="d-xl-block d-flex flex-md-row overflow-auto sidebar-container">
                                @foreach ($data->channels as $channel)
                                    <a href="{{ url($slug . '?channel_code=' . $channel->code) }}"
                                        class="text-decoration-none">
                                        <div id="{{ $channel->code == $channel->active_channel_code ? 'active-card' : '' }}"
                                            class="card-cc h-100 shadow p-2 rounded mb-2 {{ $channel->code == $channel->active_channel_code ? 'active-card' : '' }}">
                                            <img src="{{ $channel->poster }}" class="card-img-top" alt="Poster">
                                            <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                                <h6 class="card-title mb-0" style="font-size: 0.9rem;">
                                                    {{ $channel->name }}
                                                </h6>
                                                <a href="{{route('channel.streams',$channel->code) }}"
                                                    class="text-decoration-none">
                                                    <button class="btn btn-primary btn-sm px-2">Play</button>
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>


                        <!-- Calendar Section -->
                        <div class="col-xl-10">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    @else
        <section>
            <div class="container-fluid mt-3 mb-3 d-flex justify-content-center align-items-center"
                style="min-height: 50vh;">
                <div class="text-center">
                    <h3 class="card-title mb-3">Channels Not Found!</h3>
                    <h6 class="card-title mb-3">Sorry, no channels are available right now. Please check back later.</h6>
                    <a href="{{ url('/') }}" class="btn btn-primary">Go Back to Home</a>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const activeCard = document.querySelector('#active-card');
            if (activeCard) {
                activeCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'start'
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Static values for timezone and events
            var timezone = "America/New_York"; // Example timezone
            // Convert the server-rendered JSON for use in JavaScript
            var Events = {!! isset($data->calendarEventsJson) && $data->calendarEventsJson
                ? json_encode($data->calendarEventsJson)
                : '[]' !!};

            var calendarEl = document.getElementById('calendar');

            // Initialize FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: timezone,
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                weekNumbers: true,
                dayMaxEvents: true,
                nowIndicator: true,
                editable: false,
                eventStartEditable: false,
                selectable: false,
                selectHelper: false,
                events: Events,
                eventColor: '{{ \App\Services\AppConfig::get()->app->website_colors->themeActiveColor }}',
                backgroundColor: '{{ \App\Services\AppConfig::get()->app->website_colors->bgcolor }}',
                textColor: '{{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}',
                borderColor: '{{ \App\Services\AppConfig::get()->app->website_colors->themePrimaryTxtColor }}',

                // Event Tooltip Configuration
                eventDidMount: function(info) {
                    var streams = info.event.extendedProps.streams ?
                        info.event.extendedProps.streams.map(stream => stream.title).join(', ') :
                        'N/A';

                    // Limit tooltip content length
                    if (streams.length > 100) {
                        streams = streams.substring(0, 100) + '...';
                    }

                    // Tooltip content with conditional data
                    var tooltipContent = `
            <b>${info.event.title}</b><br>
            <strong>Streams:</strong> ${streams}
        `;

                    // Initialize Bootstrap popover
                    $(info.el).popover({
                        title: '',
                        content: tooltipContent,
                        html: true,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body'
                    });
                },
            });

            // Render the calendar
            calendar.render();

            // Log all events for debugging
            var allEvents = calendar.getEvents();
            console.log(allEvents);

        });
    </script>
@endpush
