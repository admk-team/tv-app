@extends('layouts.app')

@section('content')
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                    @if (Str::startsWith($sub['transaction_id'], 'sub_'))
                                        {{-- <form action="{{ route('cancel.subscription', $sub['transaction_id']) }}"> --}}
                                            <button type="button" class="app-primary-btn rounded" data-id="{{ $sub['transaction_id'] }}" id="openCancelModal">Cancel</button>
                                        {{-- </form> --}}
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
        
        <!-- Cancel subscription modal -->
        <div class="modal fade" id="cancelSubModal" tabindex="-1" role="dialog"aria-labelledby="cancelSubModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered sharing-madal" role="document">
                <div class="modal-content bg-white">
                 <div class="modal-header">
                    <h2 class="modal-title-delete">Confirmation</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        
                        <h6 align="center" style="margin:0;">We respect your decision message. You’re always welcome back.</h6>
                    </div>
                    <input type="hidden" name="subid" id="subId">

                    <div class="modal-footer">
                        {{-- <button type="button" id="subDiscount" class="app-primary-btn rounded">Discount</button> --}}
                        <button type="button" id="pauseSub" class="app-primary-btn rounded">Pause</button>
                        <button type="button" id="cancelSub" class="app-primary-btn rounded">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
