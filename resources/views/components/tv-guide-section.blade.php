    <section>
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
                                    if (!empty($channels)) {
                                        foreach ($channels as $key => $channel) {
                                            $episodeDisplayed = false;
                                        }
                                    }
                                @endphp
                                @foreach ($channels as $key => $channel)
                                    @php
                                        $episodeDisplayed = false;
                                    @endphp

                                    {{-- <a href="{{ route('player.tvguide', ['channelGuid' => $channel->id]) }}"> --}}
                                    <div class="main-container" style="display: flex;border: 1px solid;">
                                        <div class="channnel">
                                            <div class="channnel_ch_icon">
                                                <img src="{{ $channel->ch_icon }}">
                                            </div>
                                            <div class="channnel_detail">
                                                <p>{{ $channel->ch_no }}</p>
                                                <p>{{ $channel->title }}</p>
                                            </div>
                                        </div>

                                        @php
                                            $episodeDisplayed = false; // Initialize the flag
                                        @endphp
                                        @foreach ($channel->epg as $show)
                                            @php
                                                $showTime = strtotime($show->start_time);
                                                $showTime1 = strtotime($show->end_time);
                                                date_default_timezone_set('Asia/Kolkata');
                                                $current = date('H:i:s');
                                                $currentTime = strtotime($current);
                                                $timeDifference = ($showTime1 - $showTime) / 60;
                                                $detect = '';
                                                $userAgent = $_SERVER['HTTP_USER_AGENT'];

                                                if (strpos($userAgent, 'Mobile') !== false) {
                                                    $detect = $timeDifference * 5;
                                                } else {
                                                    $detect = $timeDifference * 10;
                                                }
                                            @endphp

                                            <div class="shows"
                                                style="display: flex; width: {{ $detect }}px;">
                                                <div class="tooltip">
                                                    <a
                                                        href="{{ route('player.tvguide', ['channelGuid' => $channel->id]) }}">
                                                        {{-- href="{{ $showTime <= $currentTime ? $show->poster : 'javascript:void(0)' }}"> --}}
                                                        <div class="shows-eps">
                                                            <p>{{ $show->title }}</p>
                                                            <p>{{ $show->duration }} MIN</p>
                                                        </div>
                                                    </a>
                                                    <span class="tooltiptext">
                                                        <a>
                                                            <a
                                                                href="{{ route('player.tvguide', ['channelGuid' => $channel->id]) }}">{{ $show->title }}</a>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="data not_available">
                                            <div class="shows">Show not available</div>
                                        </div>
                                    </div>
                                    {{-- </a> --}}
                                    @if ($cnt == 1)
                                    @break
                                @endif

                                @php
                                    $cnt++;
                                @endphp
                            @endforeach

                            <div class="current-time-line" id="current-time-line"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

</section>
@push('scripts')
    <script>
        $(document).ready(function() {
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

            // const currentTime = `${newHours}:${newMinutes < 10 ? '0' : ''}${newMinutes} ${amOrPm}`;
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
                // Make an AJAX request to get the current time
                const now = new Date();

                const hours = now.getHours();
                const minutes = now.getMinutes();
                const time = hours + ':' + minutes;

                function convertH2M(timeInHour) {
                    var timeParts = timeInHour.split(":");
                    return Number(timeParts[0]) * 60 + Number(timeParts[1]);
                }
                var timeInMinutes = convertH2M(time);
                let totalMinutes; // Changed const to let

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

            // Update the current time line every minute (you can adjust the interval as needed)
            setInterval(updateCurrentTimeLine, 100);
        });
    </script>
@endpush
