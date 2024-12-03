@extends('layouts.app')

@section('content')
    <section class="credential_form signForm">
        <div>
        </div>
        <div class="login_page main_pg">
            <div class="inner-cred">
                <div class="rightArow">
                    <a href="{{ route('home') }}"><img src="{{ asset('assets/images/arrow.png') }}"></a>
                </div>
                <h4>Transaction History</h4>
                <table class="view_table">
                    <thead>
                        <tr>
                            <th>Sr. No </th>
                            <th>Plan Name</th>
                            <th>Plan Type</th>
                            <th>Transaction Id</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Expired On</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subsHistory as $sub)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sub['plan_name'] }}</td>
                                <td>{{ $sub['plan_type'] }}</td>
                                <td>{{ $sub['transaction_id'] }}</td>
                                <td class="text-center">$ {{ $sub['amount'] }}</td>
                                <td class="text-center">
                                    <span class="active">{{ $sub['plan_status'] }}</span>
                                </td>
                                <td class="text-center">{{ $sub['expiry_date'] }}</td>
                                <td>
                                    @if (Str::startsWith($sub['transaction_id'], 'sub_') && $sub['payment_information'] === 'canceled')
                                        Subscription Canceled
                                    @elseif (Str::startsWith($sub['transaction_id'], 'sub_'))
                                        <form action="{{ route('cancel.subscription', $sub['transaction_id']) }}">
                                            <button class="app-primary-btn rounded" type="submit">Cancel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">{{ $subsMsg }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
