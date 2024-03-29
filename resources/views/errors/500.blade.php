@extends('errors::minimal')

{{-- @section('title', __('Server Error')) --}}
@section('title', __('Something Went Wrong'))
@section('code', '500')
{{-- @section('message', __('Server Error')) --}}
@section('message', __('Something Went Wrong'))
