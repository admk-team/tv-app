@extends('layouts.app')
@section('content')
@php
    $subscription = \App\Services\AppConfig::get()->app->app_info->subscription_plan_design ?? 'default';
@endphp
@switch($subscription)
    @case('design1')
        @include('components.subscription-plans.design1')
        @break
    @case('design2')
        @include('components.subscription-plans.design2')
        @break
    @case('default')
    @default
        @include('components.subscription-plans.default')
@endswitch

@endsection