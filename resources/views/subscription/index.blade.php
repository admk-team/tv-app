@extends('layouts.app')

@section('content')
    <div class="login_page topinnew_gaps pt-0">
        <div class="demo10">
            <div class="container" style="max-width: 1140px;">
                @if (\App\Helpers\GeneralHelper::subscriptionIsRequired())
                    <div class="subscription-required-msg">Subscribe to watch content!</div>
                @endif
                <div class="detailtitle">Subscription Plans</div>
                <div class="row">
                    @foreach (\App\Services\AppConfig::get()->app->s_plan as $plan)
                        @php
                            $suffix = '';
                            $planStr = '';
                            $periodStr = ''; // Variable to store the period string

                            // Determine the suffix for pluralization
                            if ($plan->plan_faq > 1) {
                                $suffix = 's';
                            }
                            // Determine the period string (Month/Year) based on the plan period
                            if ($plan->plan_period == 'month') {
                                $periodStr =
                                    $plan->plan_faq == 1 ? 'Every Month' : 'every ' . $plan->plan_faq . ' months';
                            } elseif ($plan->plan_period == 'year') {
                                $periodStr =
                                    $plan->plan_faq == 1 ? 'Every Year' : 'every ' . $plan->plan_faq . ' years';
                            } else {
                                $periodStr = 'every ' . $plan->plan_faq . ' ' . $plan->plan_period . $suffix;
                            }
                            // Determine the button label based on the plan type
                            if ($plan->plan_type == 'T') {
                                $planStr = session()->has('USER_DETAILS') ? 'Subscribe Free' : 'Login';
                            } elseif ($plan->plan_type == 'D') {
                                $planStr = session()->has('USER_DETAILS') ? 'Donate Now' : 'Login';
                            } else {
                                $planStr = session()->has('USER_DETAILS') ? 'Subscribe Now' : 'Login';
                            }
                        @endphp

                        <div class="col-md-4 col-sm-6">
                            <div class="pricingTable10">
                                <div class="pricingTable-header">
                                    <h3 class="heading">{{ $plan->plan_name }}</h3>
                                    <span class="price-value">
                                        <span class="currency">$</span> {{ $plan->plan_amount }}
                                        <span class="month">{{ $periodStr }}</span>
                                    </span>
                                </div>
                                <div class="pricing-content">
                                    {!! $plan->plan_desc !!}

                                    {{-- Hidden Stripe Details if Available --}}
                                    <form action="{{ route('monetization') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="SUBS_TYPE" value="S">
                                        <input type="hidden" name="PLAN_TYPE" value="{{ $plan->plan_type }}">
                                        <input type="hidden" name="PLAN_PERIOD" value="{{ $plan->plan_period }}">
                                        <input type="hidden" name="PAYMENT_INFORMATION" value="{{ $plan->plan_name }}">
                                        {{-- Hidden PayPal Plan Information --}}
                                        <input type="hidden" name="PAYPAL_PLAN_ID"
                                            value="{{ isset($plan->paypal_plan_id) ? $plan->paypal_plan_id : '' }}">
                                        <input type="hidden" name="PAYPAL_PLAN_NAME"
                                            value="{{ isset($plan->paypal_plan_name) ? $plan->paypal_plan_name : '' }}">
                                        <input type="hidden" name="PAYPAL_PLAN_PRICE"
                                            value="{{ isset($plan->paypal_plan_price) ? $plan->paypal_plan_price : '' }}">
                                        <input type="hidden" name="PAYPAL_PLAN_DURATION"
                                            value="{{ isset($plan->paypal_plan_duration) ? $plan->paypal_plan_duration : '' }}">
                                        <input type="hidden" name="PAYPAL_PLAN_TRAIL"
                                            value="{{ isset($plan->paypal_plan_trail) ? $plan->paypal_plan_trail : '' }}">


                                        <input type="hidden" name="MONETIZATION_TYPE" value="S">
                                        <input type="hidden" name="STREAM_DESC" value="{{ $plan->plan_desc }}">
                                        <input type="hidden" name="PLAN" value="{{ $periodStr }}">
                                        <input type="hidden" name="MONETIZATION_GUID" value="{{ $plan->sub_plan_guid }}">
                                        <input type="hidden" name="AMOUNT" value="{{ $plan->plan_amount }}">

                                        {{-- Hidden Stripe Information --}}
                                        <input type="hidden" name="stripe_product_id"
                                            value="{{ $plan->stripe_product_id ?? '' }}">
                                        <input type="hidden" name="stripe_product_name"
                                            value="{{ $plan->stripe_product_name ?? '' }}">
                                        <input type="hidden" name="stripe_product_price"
                                            value="{{ $plan->stripe_product_price ?? '' }}">
                                        <input type="hidden" name="stripe_product_interval"
                                            value="{{ $plan->stripe_product_interval ?? '' }}">


                                        @if (request()->has('recipient_email'))
                                            <input type="hidden" name="RECIPIENT_EMAIL"
                                                value="{{ request('recipient_email') }}">
                                        @endif
                                        <button type="submit"
                                            class="btn btn-primary read text-black text-white">{{ $planStr }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
