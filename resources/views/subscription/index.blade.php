@extends('layouts.app')

@section('content')
    <div class="login_page topinnew_gaps pt-0">
        <div class="demo10">
            <div class="container" style="max-width: 1140px;">
                <div class="detailtitle">Subscription Plans</div>
                <div class="row">
                    @foreach ($api_data->app->s_plan as $plan)
                        @php
                            $suffix = '';
                            $planStr = '';

                            if ($plan->plan_faq > 1) {
                                $suffix = 's';
                            }
                            if ($plan->plan_type == 'T') {
                                $planStr = 'Subscribe Free';
                            } elseif ($plan->plan_type == 'D') {
                                $planStr = 'Donate Now';
                            } else {
                                $planStr = 'Subscribe Now';
                            }
                        @endphp

                        <div class="col-md-4 col-sm-6">
                            <div class="pricingTable10">
                                <div class="pricingTable-header">
                                    <h3 class="heading">{{ $plan->plan_name }}</h3>
                                    <span class="price-value">
                                        <span class="currency">$</span> {{ $plan->plan_amount }} <span class="month">for
                                            {{ $plan->plan_faq . ' ' . $plan->plan_period . $suffix }}</span>
                                    </span>
                                </div>
                                <div class="pricing-content">
                                    {!! $plan->plan_desc !!}
                                    <form action="{{ route('monetization') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="SUBS_TYPE" value="S">
                                        <input type="hidden" name="PLAN_TYPE" value="{{ $plan->plan_type }}">
                                        <input type="hidden" name="PLAN_PERIOD" value="{{ $plan->plan_period }}">
                                        <input type="hidden" name="PAYMENT_INFORMATION" value="{{ $plan->plan_name }}">
                                        <input type="hidden" name="MONETIZATION_TYPE" value="S">
                                        <input type="hidden" name="STREAM_DESC" value="{{ $plan->plan_desc }}">
                                        <input type="hidden" name="PLAN" value="{{ $plan->plan_faq }}">
                                        <input type="hidden" name="MONETIZATION_GUID" value="{{ $plan->sub_plan_guid }}">
                                        <input type="hidden" name="AMOUNT" value="{{ $plan->plan_amount }}">
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
