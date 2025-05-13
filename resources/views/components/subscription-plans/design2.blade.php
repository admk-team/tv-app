@extends('layouts.app')
@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/subscription-plan2.css') }}">
@endsection
@section('content')
<div class="login_page topinnew_gaps pt-0">
    <div class="demo10">
        <div class="container my-5" style="max-width: 1140px;">
            @if (\App\Helpers\GeneralHelper::subscriptionIsRequired())
            <div class="subscription-required-msg">Subscribe to watch content!</div>
            @endif

            <div class="detailtitle">Subscription Plans</div>
            <div class="row justify-content-center">
                @foreach (\App\Services\AppConfig::get()->app->s_plan as $plan)
                @php
                $suffix = $plan->plan_faq > 1 ? 's' : '';
                $periodStr = match ($plan->plan_period) {
                'month' => $plan->plan_faq == 1 ? 'Every Month' : 'every ' . $plan->plan_faq . ' months',
                'year' => $plan->plan_faq == 1 ? 'Every Year' : 'every ' . $plan->plan_faq . ' years',
                default => 'every ' . $plan->plan_faq . ' ' . $plan->plan_period . $suffix
                };
                $planStr = session()->has('USER_DETAILS')
                ? ($plan->plan_type == 'T' ? 'Subscribe Free' : ($plan->plan_type == 'D' ? 'Donate Now' : 'Subscribe Now'))
                : 'Login';
                $icon = match ($plan->plan_type) {
                'T' => 'fas fa-gift',
                'D' => 'fas fa-hand-holding-heart',
                default => 'fas fa-star'
                };
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card subscription-card shadow-lg border-light">
                        <div class="card-body text-center">
                            <h4 class="card-title">{{ $plan->plan_name }}</h4>
                            <i class="{{ $icon }} fa-3x mb-3"></i>
                            <div class="card-text">{!! $plan->plan_desc !!}</div>
                            <p class="price mt-3">
                                <span class="currency">${{ $plan->plan_amount }}</span>
                                <br><small class="text">{{ $periodStr }}</small>
                            </p>
                            <form action="{{ route('monetization') }}" method="POST">
                                @csrf
                                <input type="hidden" name="SUBS_TYPE" value="{{ $plan->plan_type == 'ES' ? 'ES' : 'S' }}">
                                <input type="hidden" name="PLAN_TYPE" value="{{ $plan->plan_type }}">
                                <input type="hidden" name="PLAN_PERIOD" value="{{ $plan->plan_period }}">
                                <input type="hidden" name="PAYMENT_INFORMATION" value="{{ $plan->plan_name }}">
                                <input type="hidden" name="PAYPAL_PLAN_ID" value="{{ $plan->paypal_plan_id ?? '' }}">
                                <input type="hidden" name="PAYPAL_PLAN_NAME" value="{{ $plan->paypal_plan_name ?? '' }}">
                                <input type="hidden" name="PAYPAL_PLAN_PRICE" value="{{ $plan->paypal_plan_price ?? '' }}">
                                <input type="hidden" name="PAYPAL_PLAN_DURATION" value="{{ $plan->paypal_plan_duration ?? '' }}">
                                <input type="hidden" name="PAYPAL_PLAN_TRAIL" value="{{ $plan->paypal_plan_trail ?? '' }}">
                                <input type="hidden" name="MONETIZATION_TYPE" value="{{ $plan->plan_type == 'ES' ? 'ES' : 'S' }}">
                                <input type="hidden" name="STREAM_DESC" value="{{ $plan->plan_desc }}">
                                <input type="hidden" name="PLAN" value="{{ $periodStr }}">
                                <input type="hidden" name="MONETIZATION_GUID" value="{{ $plan->sub_plan_guid }}">
                                <input type="hidden" name="AMOUNT" value="{{ $plan->plan_amount }}">
                                <input type="hidden" name="stripe_product_id" value="{{ $plan->stripe_product_id ?? '' }}">
                                <input type="hidden" name="stripe_product_name" value="{{ $plan->stripe_product_name ?? '' }}">
                                <input type="hidden" name="stripe_product_price" value="{{ $plan->stripe_product_price ?? '' }}">
                                <input type="hidden" name="stripe_product_interval" value="{{ $plan->stripe_product_interval ?? '' }}">
                                @if (request()->has('recipient_email'))
                                <input type="hidden" name="RECIPIENT_EMAIL" value="{{ request('recipient_email') }}">
                                @endif
                                <button type="submit" class="btn w-100 mt-3">{{ $planStr }}</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    // Store the selected plan
    let selectedPlan = '';

    function selectPlan(plan) {
        selectedPlan = plan;
        document.getElementById('selectedPlan').textContent = `You have selected the ${capitalizeFirstLetter(plan)} Plan.`;
    }

    // Capitalize first letter of plan name
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Handle the payment form submission
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
        event.preventDefault();
        alert(`Payment for the ${capitalizeFirstLetter(selectedPlan)} Plan has been successfully processed!`);
        // Here you can add further logic like sending payment info to the backend, etc.
    });
</script>
@endsection