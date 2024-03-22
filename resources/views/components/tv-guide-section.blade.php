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
                                <div style="width: 300px;">
                                    <div>{{ $day }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>0:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>0:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>1:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>1:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>2:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>2:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>3:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>3:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>4:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>4:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>5:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>5:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>6:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>6:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>7:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>7:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>8:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>8:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>9:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>9:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 AM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>1:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>1:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>2:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>2:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>3:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>3:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>4:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>4:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>5:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>5:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>6:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>6:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>7:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>7:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>8:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>8:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>9:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>9:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 PM</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>00:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>00:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 AM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 PM</div>
                                    <div>{{ $nextDate }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>00:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>00:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 AM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 PM</div>
                                    <div>{{ $nextDate1 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>00:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>00:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 AM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>12:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>01:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>02:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>03:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>04:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>05:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>06:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>07:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>08:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>09:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>10:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:00 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                                <div style="width: 300px;">
                                    <div>11:30 PM</div>
                                    <div>{{ $nextDate2 }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="chanel-inr">
                            @php
                                $cnt = 0;
                                $ARR_FEED_DATA = \App\Helpers\GeneralHelper::parseMainFeedArrData(0, (array) $data);
                                $channels = $ARR_FEED_DATA['arrChannelsData'];
                                $channels = json_decode(json_encode($channels), true);
                            @endphp

                            @foreach ($channels as $key => $channel)
                                @php
                                    $episodeDisplayed = false;
                                @endphp
                                <div class="main-container" style="display: flex;border: 1px solid;">
                                    <div class="channnel">
                                        <div class="channnel_ch_icon">
                                            <a
                                                href="{{ route('player.tvguide', ['channelGuid' => $channel['id'], 'slug' => $slug]) }}">
                                                <img src="{{ $channel['ch_icon'] }}"></a>
                                        </div>
                                        <div class="channnel_detail">
                                            <p>{{ $channel['ch_no'] }}</p>
                                            <p>
                                                <a class="text-decoration-none"
                                                    href="{{ route('player.tvguide', ['channelGuid' => $channel['id'], 'slug' => $slug]) }}">
                                                    {{ $channel['title'] }}
                                                </a>
                                            </p>
                                        </div>

                                    </div>

                                    @php
                                        $startTime = strtotime($currentDate . ' 00:00:00');
                                        $endTime = strtotime($currentDate . ' +3 days 23:59:59');
                                        $episodeDisplayed = false;
                                    @endphp
                                    @foreach ($channel['epg'] as $show)
                                        @php

                                            $showStartTime = strtotime($show['start_date_time_utc']);
                                            $showEndTime = strtotime($show['end_date_time_utc']);
                                            $intersectionStartTime = max($startTime, $showStartTime);
                                            $intersectionEndTime = min($endTime, $showEndTime);

                                        @endphp
                                        @if ($intersectionStartTime < $intersectionEndTime)
                                            @php

                                                $timeDifference = ($intersectionEndTime - $intersectionStartTime) / 60;
                                                $detect = '';

                                                $userAgent = request()->server('HTTP_USER_AGENT');
                                                if (strpos($userAgent, 'Mobile') !== false) {
                                                    $detect = $timeDifference * 5;
                                                } else {
                                                    $detect = $timeDifference * 10;
                                                }
                                            @endphp
                                            <div class="shows"
                                                style="display: flex; width:{{ $detect }}px ;">
                                                <div class="tooltip">
                                                    <a
                                                        href="{{ route('player.tvguide', ['channelGuid' => $channel['id'], 'slug' => $slug]) }}">
                                                        <div class="shows-eps">
                                                            <p>{{ $show['title'] }}</p>
                                                            <p> {{ $show['duration'] }} MIN</p>
                                                        </div>
                                                    </a>
                                                    <span class="tooltiptext">
                                                        <a
                                                            href="{{ route('player.tvguide', ['channelGuid' => $channel['id'], 'slug' => $slug]) }}">
                                                            {{ $show['title'] }}
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                            @php $episodeDisplayed = true; @endphp
                                        @endif
                                    @endforeach
                                    @if (!$episodeDisplayed)
                                        <div class="not_available">
                                            <div class="shows">No shows available for today</div>
                                        </div>
                                    @endif
                                    {{-- echo '<div class="not_available">
                                        <div class="shows">No shows available for today</div>
                                    </div>' --}}
                                </div>
                                @php
                                    if ($cnt == 1) {
                                    }
                                    $cnt++;
                                @endphp
                            @endforeach
                            <div class="current-time-line" id="current-time-line"></div>
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
        let totalMinutes;

        if (minutes > 30) {
            totalMinutes = minutes - 30; // Changed var to let
        } else {
            totalMinutes = minutes;
        }
        let marginLeft;
        var userAgent = navigator.userAgent;
        if (/Mobi/.test(userAgent)) {
            marginLeft = 300 + timeInMinutes * 5;
        } else {
            marginLeft = 300 + timeInMinutes * 10;
        }
        const currentTimeLine = document.getElementById('current-time-line');
        currentTimeLine.style.marginLeft = `${marginLeft}px`;
    }
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
