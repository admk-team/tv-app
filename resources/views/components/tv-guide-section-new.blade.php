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

        @media only screen and (max-width: 768px) {
            .card img {
                display: none;
            }

            .card-title {
                font-size: 16px;
            }
        }
    </style>
@endsection
@section('content')
    <section>
        <div class="container-fluid mt-3 mb-3">
            <div class="container">
                <div class="row">
                    <!-- Sidebar / Navbar -->
                    <div class="col-xl-2 mt-5">
                        <!-- Sidebar for Desktop -->
                        <div class="d-none d-xl-block"> <!-- Visible only on larger screens -->
                            <div class="row g-2">
                                <!-- Card 1 (Active) -->
                                <div class="col-12">
                                    <div class="card-cc h-100 active-card shadow p-2 rounded" style="border: 2px solid var(--themeActiveColor);">
                                        <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690648679_c05_8_ac.jpg"
                                            class="card-img-top" alt="Poster">
                                        <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                            <h6 class="card-title text-truncate mb-0" style="font-size: 0.9rem;">Morning Show</h6>
                                            <button class="btn btn-primary btn-sm px-2">Play</button>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Card 2 -->
                                <div class="col-12">
                                    <div class="card-cc h-100 shadow p-2 rounded">
                                        <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690648679_c05_8_ac.jpg"
                                            class="card-img-top" alt="Poster">
                                        <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                            <h6 class="card-title text-truncate mb-0" style="font-size: 0.9rem;">Sports Hour</h6>
                                            <button class="btn btn-primary btn-sm px-2">Play</button>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Card 3 -->
                                <div class="col-12">
                                    <div class="card-cc h-100 shadow p-2 rounded">
                                        <img src="https://onlinechannel.io/storage/7376d3829575f06617d9db3f7f6836df_1690648679_c05_8_ac.jpg"
                                            class="card-img-top" alt="Poster">
                                        <div class="card-body d-flex justify-content-between align-items-center mt-1">
                                            <h6 class="card-title text-truncate mb-0" style="font-size: 0.9rem;">Evening News</h6>
                                            <button class="btn btn-primary btn-sm px-2">Play</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        {{--  <!-- Dropdown for Mobile View -->
                        <div class="d-block d-xl-none"> <!-- Visible only on mobile -->
                            <div class="dropdown">
                                <button class="btn btn-light dropdown-toggle w-100 shadow-sm mb-2" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Show
                                </button>
                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                    <!-- Dropdown Item 1 -->
                                    <li class="d-flex justify-content-between align-items-center px-3">
                                        <span class="text-truncate" style="font-size: 0.9rem;">Morning Show</span>
                                        <button class="btn btn-primary btn-sm px-2">Play</button>
                                    </li>
                                    <hr class="my-1">
                                    <!-- Dropdown Item 2 -->
                                    <li class="d-flex justify-content-between align-items-center px-3">
                                        <span class="text-truncate" style="font-size: 0.9rem;">Sports Hour</span>
                                        <button class="btn btn-primary btn-sm px-2">Play</button>
                                    </li>
                                    <hr class="my-1">
                                    <!-- Dropdown Item 3 -->
                                    <li class="d-flex justify-content-between align-items-center px-3">
                                        <span class="text-truncate" style="font-size: 0.9rem;">Evening News</span>
                                        <button class="btn btn-primary btn-sm px-2">Play</button>
                                    </li>
                                </ul>
                            </div>
                        </div>  --}}
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
