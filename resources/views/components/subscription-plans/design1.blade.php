@extends('layouts.app')
@section('head')
<link rel="stylesheet" href="{{ asset('assets/css/subscription-plan.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="container" style="max-width: 1140px;">
        @if (\App\Helpers\GeneralHelper::subscriptionIsRequired())
        <div class="subscription-required-msg">Subscribe to watch content!</div>
        @endif

        <div class="detailtitle">Subscription Plans</div>

        <div class="subscription-plans">
            <div class="row">
                @foreach (\App\Services\AppConfig::get()->app->s_plan as $plan)
                @php
                $suffix = $plan->plan_faq > 1 ? 's' : '';
                if ($plan->plan_period == 'month') {
                $periodStr = $plan->plan_faq == 1 ? 'Every Month' : 'every ' . $plan->plan_faq . ' months';
                } elseif ($plan->plan_period == 'year') {
                $periodStr = $plan->plan_faq == 1 ? 'Every Year' : 'every ' . $plan->plan_faq . ' years';
                } else {
                $periodStr = 'every ' . $plan->plan_faq . ' ' . $plan->plan_period . $suffix;
                }
                $planStr = session()->has('USER_DETAILS')
                ? ($plan->plan_type == 'T' ? 'Subscribe Free' : ($plan->plan_type == 'D' ? 'Donate Now' : 'Subscribe Now'))
                : 'Login';
                $descItems = explode("\n", strip_tags($plan->plan_desc));
                @endphp
                <div class="column fourth">
                    <div class="card" style="height: 100%;">
                        <div>
                            <h2>{{ $plan->plan_name }}</h2>
                            <h3>{{ $plan->plan_type == 'T' ? 'Free plan' : 'Premium access' }}</h3>
                            <p class="price">
                                {{ $plan->plan_type == 'T' ? 'Free' : '$' . number_format($plan->plan_amount, 2) }}
                                <span class="month">{{ $periodStr }}</span>
                            </p>
                            <ul class="feature-list">
                                @foreach ($descItems as $item)
                                <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <form action="{{ route('monetization') }}" method="POST" style="margin-top: auto;">
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
                            <button type="submit" class="btn">{{ $planStr }}</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection