{{-- @extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <div>
        </div>
        <div class="login_page main_pg">
            <div class="inner-cred">
                <div class="rightArow">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/images/arrow.png') }}"></a>
                </div>
                <h4>Watch Parties History</h4>
                <table class="view_table">
                    <thead>
                        <tr>
                            <th>Sr. No </th>
                            <th>Code</th>
                            <th>Start Date/Time</th>
                            <th>End Date/Time</th>
                            <th>Emails/th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($watchParties as $wp)
                            <tr>
                                <td>{{ $wp->iteration }}</td>
                                <td>{{ $wp['code'] }}</td>
                                <td>{{ $wp['start_time'] }}</td>
                                <td>{{ $wp['end_time'] }}</td>
                                <td>{{ $wp['email'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Record not exists</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection --}}
