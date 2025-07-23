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
                            @php
                                $amount = $sub['amount'];
                                $discount = $sub['discount'];
                                $duration = $sub['discount_duration'];
                                $period = $sub['plan_period'];
                                $discountedAmount = $discount
                                    ? round($amount - ($amount * $discount) / 100, 2)
                                    : $amount;

                                $expiryDate = Carbon\Carbon::parse($sub['expiry_date']);
                                $pausedDays = (int) ($sub['pause_days'] ?? 0);
                                $now = Carbon\Carbon::now();

                                $pausedExpiry = isset($sub['exp_backup'])
                                    ? Carbon\Carbon::parse($sub['exp_backup'])
                                    : null;

                                $isCanceled = $sub['payment_information'] === 'canceled';
                                $isPaused = $pausedDays > 0 && $pausedExpiry !== null;

                                if (!$isCanceled) {
                                    $isExpired = $pausedExpiry ? $now->gt($pausedExpiry) : $now->gt($expiryDate);
                                } else {
                                    $isExpired = false;
                                }

                                $canShowCancelButton =
                                    Str::startsWith($sub['transaction_id'], 'sub_') &&
                                    $sub['monetization_type'] === 'S' &&
                                    !$isExpired &&
                                    !$isCanceled &&
                                    !$isPaused;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sub['plan_name'] }}</td>
                                <td>{{ $sub['plan_type'] }}</td>
                                <td>{{ $sub['transaction_id'] }}</td>
                                <td class="text-center">
                                    @if ($sub['discount_status'] == 1 && !$isCanceled)
                                        <div>
                                            <span style="text-decoration: line-through;">
                                                ${{ number_format($amount, 2) }}
                                            </span><br>
                                            <span class="fw-bold">
                                                ${{ number_format($discountedAmount, 2) }}
                                            </span>
                                        </div>
                                    @else
                                        <span>${{ number_format($amount, 2) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($isCanceled)
                                        <span class="badge bg-danger">Canceled</span>
                                    @elseif ($isExpired)
                                        @if ($sub['monetization_type'] == 'S')
                                            <span class="badge bg-danger">Canceled</span>
                                        @else
                                            <span class="badge bg-secondary">Expired</span>
                                        @endif
                                    @elseif ($isPaused)
                                        <span class="badge bg-warning text-dark">Paused</span>
                                        <span class="badge bg-secondary">Paused for {{ $pausedDays }} days</span>

                                        @php
                                            $resumeDate = $expiryDate->copy()->addDays($pausedDays);
                                            $remaining = $now->diffInDays($resumeDate, false);
                                        @endphp
                                        <span class="badge bg-info">{{ $remaining }} days left</span>
                                    @else
                                        <span class="badge bg-success">Active</span>

                                        @if ($discount > 0)
                                            <div class="mt-1 small text-white">
                                                <span class="badge bg-info text-dark">
                                                    {{ $discount }}% OFF
                                                </span>
                                                <div>
                                                    <small class="badge bg-info text-dark">
                                                        For {{ $duration }} {{ Str::plural($period, $duration) }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </td>

                                <td class="text-center">
                                    {{ $isPaused ? $sub['exp_backup'] : $sub['expiry_date'] }}
                                </td>

                                <td>
                                    @if ($canShowCancelButton)
                                        <button type="button" class="app-primary-btn rounded"
                                            data-id="{{ $sub['transaction_id'] }}" id="openCancelModal"
                                            data-plan-name="{{ $sub['plan_name'] }}"
                                            data-discount="{{ $sub['discount'] }}"
                                            data-discount-duration="{{ $sub['discount_duration'] }}"
                                            data-discount-status="{{ $sub['discount_status'] }}"
                                            data-plan-period="{{ $sub['plan_period'] }}">
                                            Cancel
                                        </button>
                                        {{-- <div class="col-md-6">
                                            <button type="button" id="pauseSub" data-id="{{ $sub['transaction_id'] }}" data-value="outbutton"
                                                class="app-primary-btn rounded">Pause</button>
                                        </div> --}}
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
        <div class="modal fade" id="cancelSubModal" tabindex="-1" role="dialog"aria-labelledby="cancelSubModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered sharing-madal" role="document">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h2 class="modal-title-delete">Confirmation</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <h6 align="center" style="margin:0;">We respect your decision message. You’re always welcome back.
                        </h6>
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
