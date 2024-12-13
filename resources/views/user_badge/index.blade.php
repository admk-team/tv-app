@extends('layouts.app')




@section('content')
    <style>
        .card-custom {
            background-color: var(--bgcolor);
            color: var(--themePrimaryTxtColor);
            border: 1px solid var(--themeActiveColor) !important;
            /* Correct border declaration */
            border-radius: 4px !important;
            /* Optional: Adjust as needed */
        }
    </style>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="listing_box">
                    <div class="card mb-4 mt-4 card-custom p-2">
                        <h1>test </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
