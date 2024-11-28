@extends('layouts.app')

@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.42/moment-timezone-with-data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <style>
        .fc .fc-col-header-cell-cushion {
            color: var(--themeActiveColor) !important;
        }

        .fc .fc-daygrid-day-number {
            color: var(--themeActiveColor) !important;
        }

        .fc-daygrid-dot-event .fc-event-title {
            color: var(--themeActiveColor) !important;
        }

        .fc-direction-ltr .fc-daygrid-event .fc-event-time {
            color: var(--themeActiveColor) !important;
        }

        .fc-theme-standard .fc-scrollgrid {
            border: 1px solid var(--themeActiveColor) !important;
        }

        .fc .fc-toolbar-title {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border: 1px solid var(--themeActiveColor) !important;
        }

        .fc .fc-timegrid-axis-cushion {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc .fc-timegrid-slot-label-cushion {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc-timegrid-event .fc-event-time {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc-v-event .fc-event-title {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc-direction-ltr .fc-list-day-text,
        .fc-direction-rtl .fc-list-day-side-text {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc-direction-ltr .fc-list-day-side-text,
        .fc-direction-rtl .fc-list-day-text {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc .fc-list-day-cushion,
        .fc .fc-list-table td {
            color: var(--themePrimaryTxtColor) !important;
        }

        .fc .fc-list-sticky .fc-list-day>* {
            background: var(--themeActiveColor) !important;
        }

        .fc .fc-list-event:hover td {
            background-color: var(--themeActiveColor) !important;
        }

        .fc .fc-daygrid-more-link {
            color: var(--themePrimaryTxtColor) !important;
        }

        @media only screen and (max-width: 768px) {
            .fc .fc-toolbar {
                display: block !important;
            }
        }

        .card {
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: var(--themePrimaryTxtColor);
        }

        .btn-primary {
            background-color: var(--themeActiveColor);
            border-color: var(--themeActiveColor);
        }

        .btn-primary:hover {
            background-color: darken(var(--themeActiveColor), 10%);
        }

        /* Sidebar scroll for vertical cards on desktop */
        .sidebar-container {
            overflow-y: auto !important;
            scrollbar-width: thin !important;
            /* Firefox */
        }

        .sidebar-container::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar-container::-webkit-scrollbar-thumb {
            background: var(--themeActiveColor);
            border-radius: 10px;
        }

        @media only screen and (max-width: 768px) {


            .card-title {
                font-size: 16px;
                margin-right: 5px;
            }
        }

        /* Horizontal scroll for mobile */
        @media (max-width: 992px) {
            .sidebar-container {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                padding: 10px 0;
            }

            .card-cc {
                flex: 0 0 48%;
                margin-right: 10px;
            }
        }

        /* General Card Styling */
        .card {
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: var(--themePrimaryTxtColor);
        }

        .btn-primary {
            background-color: var(--themeActiveColor);
            border-color: var(--themeActiveColor);
        }

        .btn-primary:hover {
            background-color: darken(var(--themeActiveColor), 10%);
        }
    </style>
@endsection
@section('content')
    @if (isset($data->channels) && $data->channels)
        <section>
            <div class="container-fluid mt-3 mb-3">
                <div class="container">
                    <div class="row">
                        <!-- Sidebar / Navbar -->

                        <div class="col-xl-2 mt-5" style="overflow: auto; max-height:70vh;">
                            <!-- Sidebar for All Screens -->
                            <div class="d-xl-block d-flex flex-md-row overflow-auto sidebar-container">
                                <!-- Cards -->
                                @foreach ($data->channels as $channel)
                                    <a href="{{ url($slug . '?channel_code=' . $channel->code) }}"
                                        class="text-decoration-none">
                                        <div class="card-cc h-100 shadow p-2 rounded mb-2 {{ $channel->code == $channel->active_channel_code ? 'active-card' : '' }}"
                                            style="{{ $channel->code == $channel->active_channel_code ? 'border: 2px solid var(--themeActiveColor);' : '' }}">

                                            <img src="{{ $channel->poster }}" class="card-img-top" alt="Poster">

                                            <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                                <h6 class="card-title mb-0" style="font-size: 0.9rem;">{{ $channel->name }}
                                                </h6>
                                                <a href="{{ route('channel.streams', $channel->code) }}"
                                                    class="text-decoration-none">
                                                    <button class="btn btn-primary btn-sm px-2">Play</button>
                                                </a>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                {{--  <div class="card-cc h-100 shadow p-2 rounded mb-2">
                                    <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690648679_c05_8_ac.jpg"
                                        class="card-img-top " alt="Poster">
                                    <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                        <h6 class="card-title mb-0" style="font-size: 0.9rem;">Movie Channel 23</h6>
                                        <button class="btn btn-primary btn-sm px-2">Play</button>
                                    </div>
                                </div>

                                <div class="card-cc h-100 shadow p-2 rounded mb-2">
                                    <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690648679_c05_8_ac.jpg"
                                        class="card-img-top " alt="Poster">
                                    <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                        <h6 class="card-title mb-0" style="font-size: 0.9rem;">Evening News</h6>
                                        <button class="btn btn-primary btn-sm px-2">Play</button>
                                    </div>
                                </div>
                                <div class="card-cc h-100 shadow p-2 rounded mb-2">
                                    <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690648679_c05_8_ac.jpg"
                                        class="card-img-top " alt="Poster">
                                    <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                        <h6 class="card-title mb-0" style="font-size: 0.9rem;">Evening News</h6>
                                        <button class="btn btn-primary btn-sm px-2">Play</button>
                                    </div>
                                </div>
                                <div class="card-cc h-100 shadow p-2 rounded mb-2">
                                    <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690648679_c05_8_ac.jpg"
                                        class="card-img-top " alt="Poster">
                                    <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                        <h6 class="card-title mb-0" style="font-size: 0.9rem;">Evening News</h6>
                                        <button class="btn btn-primary btn-sm px-2">Play</button>
                                    </div>
                                </div>  --}}

                                <!-- Add more cards as needed -->
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
            <div class="container-fluid mt-3 mb-3">
                <div class="container">
                    <div class="row">
                        <h6 class="card-title  mb-0" style="font-size: 0.9rem;">Channels are not found!</h6>
                    </div>
                </div>
            </div>

        </section>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Static values for timezone and events
            var timezone = "America/New_York"; // Example timezone
            var Events = [{
                    title: "Morning Show",
                    start: "2024-11-27T08:00:00",
                    end: "2024-11-27T10:00:00",
                    description: "A popular morning show",
                },
                {
                    title: "Sports Hour",
                    start: "2024-11-27T11:00:00",
                    end: "2024-11-27T12:00:00",
                    description: "Live sports analysis",
                },
                {
                    title: "Evening News",
                    start: "2024-11-27T18:00:00",
                    end: "2024-11-27T19:00:00",
                    description: "Daily news coverage",
                },
            ];

            var calendarEl = document.getElementById('calendar');
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
                eventDidMount: function(info) {
                    var tooltipContent =
                        `<b>${info.event.title}</b><br>${info.event.extendedProps.description}`;
                    $(info.el).popover({
                        title: 'Event Details',
                        content: tooltipContent,
                        html: true,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body',
                    });
                },
            });

            calendar.render();

            var allEvents = calendar.getEvents();
            console.log(allEvents);
        });
    </script>
@endpush
