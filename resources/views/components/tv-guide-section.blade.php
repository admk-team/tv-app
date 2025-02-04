<section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.js"></script>

    <div class="top_gaps" style="padding-top:-100px!important;">
        <div class="container-fluid">
            <div class="main_tv_Guide">
                <div class="container">
                    <div class="channels">


                        @php

                            $currentDate = date('Y-m-d');
                            $day = date('l'); // This will return the full day name (e.g., "Monday", "Tuesday", etc.)

                            $nextDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                            $nextDate1 = date('Y-m-d', strtotime($currentDate . ' +2 day'));
                            $nextDate2 = date('Y-m-d', strtotime($currentDate . ' +3 day'));

                        @endphp

                        <div class="timeline">
                            <div class="list">
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>{{ $day }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>0:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>0:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>1:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>1:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>2:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>2:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>3:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>3:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>4:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>4:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>5:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>5:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>6:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>6:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>7:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>7:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>8:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>8:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>9:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>9:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>10:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>10:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>11:00 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>11:30 AM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>12:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>12:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>1:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>1:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>2:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>2:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>3:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>3:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>4:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>4:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>5:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>5:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>6:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>6:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>7:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>7:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>8:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>8:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>9:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>9:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                    <div>10:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:00 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:30 PM</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>00:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>00:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>12:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>12:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>00:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>00:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>12:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>12:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>01:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>02:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>03:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>04:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>05:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>06:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>07:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>08:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>09:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>10:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px; margin-left:0.3rem;"
                                    class="shadow bg-body-tertiary rounded">
                                    <div>11:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="chanel-inr">
                            @php
                                $cnt = 0;
                                $ARR_FEED_DATA = \App\Helpers\GeneralHelper::parseMainFeedArrData(0, (array) $data);
                                $channels = $ARR_FEED_DATA['arrChannelsData'];
                                $channels = json_decode(json_encode($data->channels), true);
                            @endphp
                            @foreach ($channels as $channel)
                                @php
                                    $episodeDisplayed = false;
                                @endphp
                                <div class="main-container"
                                    style="display: flex; border: 1px solid;background: none; margin-top: 1rem;">
                                    <!-- Channel Information -->
                                    <div class="channnel shadow bg-body-tertiary rounded">
                                        <div class="channnel_ch_icon">
                                            <a
                                                href="{{ route('player.tvguide', ['channelGuid' => $channel['code'], 'slug' => $slug]) }}">
                                                <img src="{{ $channel['ch_icon'] }}"
                                                    alt="{{ $channel['title'] }}">
                                            </a>
                                        </div>
                                        <div class="channnel_detail">
                                            <span># {{$channel['channel_no']}}</span>
                                            <p>
                                                <a class="text-decoration-none"
                                                    href="{{ route('player.tvguide', ['channelGuid' => $channel['code'], 'slug' => $slug]) }}">
                                                    {{ $channel['title'] }}
                                                </a>
                                            </p>
                                        </div>
                                    </div>


                                    @foreach ($channel['schedules'] as $scheduleDay)
                                        <!-- Loop through days of schedules -->
                                        @foreach ($scheduleDay['schedules'] as $schedule)
                                            @php
                                                $currentStreamStartTime = strtotime($schedule['start_time']);
                                                $endOfSchedule = strtotime($schedule['end_time']);
                                                $streams = $schedule['streams'] ?? [];
                                                $scheduleDuration = ($endOfSchedule - $currentStreamStartTime) / 60; // Duration of schedule in minutes
                                                $userAgent = request()->server('HTTP_USER_AGENT');
                                                $detect =
                                                    strpos($userAgent, 'Mobile') !== false
                                                        ? $scheduleDuration * 5
                                                        : $scheduleDuration * 10; // Adjust width based on duration
                                            @endphp

                                            @if (!empty($streams))
                                                @php $streamIndex = 0; @endphp

                                                @while ($currentStreamStartTime < $endOfSchedule)
                                                    @php
                                                        // Get the current stream details
                                                        $stream = $streams[$streamIndex];
                                                        $streamTitle = $stream['title'];
                                                        $streamPoster = $stream['poster'];
                                                        $streamDuration = $stream['duration'] ?? 0; // Default to 0 if duration is null
                                                        $streamCode = $stream['code'];

                                                        // Calculate end time for the current stream
                                                        $currentStreamEndTime =
                                                            $currentStreamStartTime + $streamDuration * 60;

                                                        // Ensure the stream doesn't exceed the schedule's end time
                                                        if ($currentStreamEndTime > $endOfSchedule) {
                                                            $currentStreamEndTime = $endOfSchedule;
                                                        }

                                                        // Format times for display
                                                        $formattedStartTime = date('h:i A', $currentStreamStartTime);
                                                        $formattedEndTime = date('h:i A', $currentStreamEndTime);

                                                        // Adjust display width based on duration
                                                        $timeDifference =
                                                            ($currentStreamEndTime - $currentStreamStartTime) / 60; // Minutes
                                                        $width =
                                                            strpos($userAgent, 'Mobile') !== false
                                                                ? $timeDifference * 5 // Slightly increase multiplier for mobile
                                                                : $timeDifference * 10; // Slightly increase multiplier for desktop

                                                        // Update the start time for the next stream
                                                        $currentStreamStartTime = $currentStreamEndTime;

                                                        // Cycle to the next stream (wrap around if needed)
                                                        $streamIndex = ($streamIndex + 1) % count($streams);
                                                    @endphp

                                                    {{-- <div class="shows"
                                                        style="display: flex; width:{{ $width }}px;margin-left:0.3rem;" class="shadow bg-body-tertiary rounded">
                                                        <div class="tooltip"> --}}
                                                    <div class="shows shadow p-3 bg-body-tertiary rounded"
                                                        style="
                                                        display: flex; width:{{ $width }}px;margin-left:0.3rem;"
                                                        class="shadow bg-body-tertiary rounded">
                                                        <div class="tooltip">
                                                            <a
                                                                href="{{ route('player.tvguide', ['channelGuid' => $channel['code'], 'slug' => $streamCode]) }}">
                                                                <div class="shows-eps">
                                                                    <div class="d-flex justify-content-center gap-2">
                                                                        <img src="{{ $streamPoster }}"
                                                                            alt="{{ $streamTitle }}"
                                                                            style="height: 60px; width:100px; border-radius: 5px;">
                                                                        <div>
                                                                            @php
                                                                                $maxLength = 25; // Set the maximum number of characters for display
                                                                                $truncatedTitle =
                                                                                    strlen($streamTitle) > $maxLength
                                                                                        ? substr(
                                                                                                $streamTitle,
                                                                                                0,
                                                                                                $maxLength,
                                                                                            ) . '...'
                                                                                        : $streamTitle;
                                                                            @endphp
                                                                            <strong
                                                                                style="font-size: 1.15rem;">{{ $truncatedTitle }}</strong>

                                                                            <p>{{ $formattedStartTime }} -
                                                                                {{ $formattedEndTime }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <span class="tooltiptext">
                                                                <a
                                                                    href="{{ route('player.tvguide', ['channelGuid' => $channel['code'], 'slug' => $streamCode]) }}">
                                                                    {{ $streamTitle }}
                                                                    <!-- Show full title in the tooltip -->
                                                                </a>
                                                            </span>

                                                        </div>
                                                    </div>
                                                @endwhile
                                            @else
                                                <!-- Placeholder for no streams -->
                                                <p class="shadow bg-body-tertiary rounded mx-2"
                                                    style="display: flex; width:{{ $detect }}px; background-color: #f8f9fa; color: #6c757d; justify-content: center; align-items: center;margin-top:1rem;">
                                                    No streams available for this schedule.
                                                </p>
                                            @endif
                                        @endforeach
                                    @endforeach



                                    @empty($channel['schedules'])
                                        <div class="not_available">
                                            <div class="shows">No schedules available for this channel</div>
                                        </div>
                                    @endempty
                                </div>
                            @endforeach

                            <div class="current-time-line" id="current-time-line" style="z-index: 99999;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var divs = document.getElementsByTagName('div');
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
    const amOrPm = hours >= 12 ? 'PM' : 'AM';

    let newMinutes = minutes - 30;
    let newHours = hours;

    if (newMinutes < 0) {
        newHours = (hours - 1 + 24) % 24;
        newMinutes += 60;
    }

    // Adjust minutes
    if (newMinutes >= 1 && newMinutes <= 30) {
        newMinutes = 0;
    } else if (newMinutes >= 31 && newMinutes <= 59) {
        newMinutes = 30;
    }
    const hours12 = newHours > 12 ? newHours - 12 : newHours;
    const currentTime = `${hours12}:${newMinutes < 10 ? '0' : ''}${newMinutes} ${amOrPm}`;

    for (var i = 0; i < divs.length; i++) {
        if (divs[i].innerText === currentTime) {
            divs[i].scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'start'
            });
            break;
        }
    }

function updateCurrentTimeLine() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const time = hours + ':' + minutes;

    function convertH2M(timeInHour) {
        var timeParts = timeInHour.split(":");
        return Number(timeParts[0]) * 60 + Number(timeParts[1]);
    }

    var timeInMinutes = convertH2M(time);
    let totalMinutes = minutes > 30 ? minutes - 30 : minutes;
    let marginLeft;

    var userAgent = navigator.userAgent;
    var screenWidth = window.innerWidth; // Get screen width
    var mobileMultiplier = screenWidth < 768 ? 6 : 10; // Adjust the scaling factor

    if (/Mobi/.test(userAgent) || screenWidth < 768) {
        marginLeft = 100 + timeInMinutes * mobileMultiplier; // Adjusted for mobile
    } else {
        marginLeft = 300 + timeInMinutes * 10;
    }

    const currentTimeLine = document.getElementById('current-time-line');
    currentTimeLine.style.marginLeft = `${marginLeft}px`;
    currentTimeLine.style.display = 'block'; // Ensure it's visible
}

// Run the function every second
setInterval(updateCurrentTimeLine, 100);

</script>

<script>
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }
    var timezone = moment.tz.guess();
    setCookie("timezoneStr", timezone, 1);
</script>
