@extends('layouts.app')

@push('style')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@500;700;900&display=swap');

        :root {
            --pale-blue: hsl(225, 100%, 94%);
            --bright-blue: hsl(245, 75%, 52%);
            --very-pale-blue: hsl(225, 100%, 98%);
            --desaturated-blue: hsl(224, 23%, 55%);
            --dark-blue: hsl(223, 47%, 23%);
        }

        section {
            background-color: #D6E1FF;
        }

        .card {
            width: 420px !important;
            min-height: 400px;
            margin: 60px auto;
            border-radius: 10px;
            background: white;
        }

        .card .card-header {
            width: 100%;
            border-radius: 10px 10px 0px 0px;
            padding: 0.75rem 1.25rem;
        }

        .card .card-header img {
            width: 100%;
            border-radius: 10px 10px 0px 0px;
        }

        .card .card-body {
            width: 100%;
            height: auto;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card .card-body .card-title {
            width: 100%;
            font-weight: 900;
            color: var(--dark-blue);
            text-align: center;
            box-sizing: border-box;
        }

        .card .card-body .card-text {
            width: 100%;
            color: var(--desaturated-blue);
            text-align: center;
            line-height: 25px;
            padding: 15px 0px;
            box-sizing: border-box;
        }

        .card .card-body .card-plan {
            display: flex;
            flex-direction: row;
            align-items: center;
            column-gap: 15px;
            background: var(--very-pale-blue);
            border-radius: 10px;
            padding: 15px;
            box-sizing: border-box;
        }

        .card .card-body .card-plan .card-plan-img {
            flex-grow: 1;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .card .card-body .card-plan .card-plan-text {
            flex-grow: 6;
            display: flex;
            flex-direction: column;
            row-gap: 4px;
        }

        .card .card-body .card-plan .card-plan-text .card-plan-title {
            color: var(--dark-blue);
            font-weight: 900;
            font-size: 14px;
        }

        .card .card-body .card-plan .card-plan-text .card-plan-price {
            color: var(--desaturated-blue);
            font-size: 14px;
        }

        .card .card-body .card-plan .card-plan-link {
            flex-grow: 1;
        }

        .card .card-body .card-plan .card-plan-link a {
            color: var(--bright-blue);
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .card .card-body .card-plan .card-plan-link a:hover {
            color: #766cf1;
            text-decoration: none;
            ;
        }

        .card .card-body .card-payment-button {
            padding: 25px 0px 15px;
            box-sizing: border-box;
        }

        .card .card-body .card-payment-button button {
            width: 100%;
            height: 50px;
            border: 0;
            background: var(--bright-blue);
            color: white;
            font-weight: 700;
            border-radius: 10px;
            box-shadow: 0px 10px 20px 0px hsl(245deg 75% 52% / 44%);
            cursor: pointer;
        }

        .card .card-body .card-payment-button button:hover {
            background: #766cf1;
        }

        .card .card-body .card-cancel-button {
            padding: 15px 0px;
            box-sizing: border-box;
        }

        .card .card-body .card-cancel-button button {
            width: 100%;
            border: 0;
            background: none;
            color: var(--desaturated-blue);
            font-weight: 900;
            text-align: center;
            cursor: pointer;
        }

        .card .card-body .card-cancel-button button:hover {
            color: var(--dark-blue);
        }

        .paypal_btn {
            background: #FFC439 !important;
        }



        /* spinner/processing state, errors */
        .hidden {
            display: none;
        }

        .spinner,
        .spinner:before,
        .spinner:after {
            border-radius: 50%;
        }

        .spinner {
            color: #ffffff;
            font-size: 22px;
            text-indent: -99999px;
            margin: 0px auto;
            position: relative;
            width: 20px;
            height: 20px;
            box-shadow: inset 0 0 0 2px;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }

        .spinner:before,
        .spinner:after {
            position: absolute;
            content: "";
        }

        .spinner:before {
            width: 10.4px;
            height: 20.4px;
            background: #30d14d;
            border-radius: 20.4px 0 0 20.4px;
            top: -0.2px;
            left: -0.2px;
            -webkit-transform-origin: 10.4px 10.2px;
            transform-origin: 10.4px 10.2px;
            -webkit-animation: loading 2s infinite ease 1.5s;
            animation: loading 2s infinite ease 1.5s;
        }

        .spinner:after {
            width: 10.4px;
            height: 10.2px;
            background: #30d14d;
            border-radius: 0 10.2px 10.2px 0;
            top: -0.1px;
            left: 10.2px;
            -webkit-transform-origin: 0px 10.2px;
            transform-origin: 0px 10.2px;
            -webkit-animation: loading 2s infinite ease;
            animation: loading 2s infinite ease;
        }

        b {
            font-weight: bold !important;
        }

        p {
            font-weight: 400 !important
        }

        a {
            text-decoration: none !important;
        }

        @-webkit-keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <section>
        <div class="container" class="margin-top:200px;">
            <div class="row">
                <div class="card px-0" style="margin-top: 10rem;">
                    <div class="card-header">
                        <!-- Display the first stream's poster as a thumbnail or a default image if not available -->
                        <img src="{{ session('MONETIZATION.relatedStreams.0.poster', asset('assets/images/plan.jpg')) }}"
                            class="img-thumbnail" alt="{{ session('MONETIZATION.title') }}">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-uppercase">Order Summary</h4>
                        <div class="card-title">{{ session('MONETIZATION.title') }}</div>
                        {{-- <p class="card-text">{{ session('MONETIZATION.description') }}</p> --}}
                        <p class="card-text">{{ session('MONETIZATION.description') }}</p>
                        <div class="card-plan">
                            <div class="card-plan-img"><img src="{{ asset('assets/images/icons/buy.png') }}" alt="">
                            </div>
                            <div class="card-plan-text">
                                <div class="card-plan-title">Amount</div>
                                <div class="card-plan-price">
                                    ${{ session('MONETIZATION.amount') }}
                                </div>
                            </div>
                        </div>

                        <!-- List of related streams with title and image -->
                        <div class="related-streams mt-3">
                            <h5>Streams</h5>
                            <div class="row">
                                @foreach (session('MONETIZATION.relatedStreams', []) as $stream)
                                    <div class="col-md-4 mb-3">
                                        <div class="stream-card">
                                            <img src="{{ $stream['poster'] }}" class="img-fluid rounded"
                                                alt="{{ $stream['title'] }}">
                                            <div class="stream-title mt-2">{{ $stream['title'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Payment Buttons and Actions -->
                        <div class="card-payment-button mt-4">
                            <!-- Your existing payment form logic here -->
                            <form
                                action="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->PAYPAL_SANDBOX == 'true' ? env('PAYPAL_SANDBOX_URL') : env('PAYPAL_URL') }}"
                                method="POST">
                                <input type="hidden" name="business"
                                    value="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->PAYPAL_ID }}">
                                {{-- <input type="hidden" name="business" value="abdul.haseeb.ali@gmail.com"> --}}
                                <input type="hidden" name="cmd" value="_xclick" />
                                <input type="hidden" name="rm" value="2">
                                <input type="hidden" name="item_name" value="BUNDLE CONTENT">
                                <input type="hidden" name="item_number" value="{{ $planData['code'] }}">
                                <input type="hidden" name="subs_type" value="BC">
                                <input type="hidden" name="monetization_type" value="O">
                                <input type="hidden" name="amount" value="{{ $planData['amount'] }}">
                                <input type="hidden" name="currency_code"
                                    value="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->payment_currency_code }}">
                                <input type="hidden" name="return" value="{{ url('/monetization/success') }}">
                                <input type="hidden" name="cancel_return" value="{{ url('/monetization/cancel') }}">
                                <button type="submit" class="btn paypal_btn"><i
                                        class="fa fa-paypal"aria-hidden="true"></i>Pay with Paypal</button>
                            </form>
                            <button class="stripe-button mt-2" id="payButton">
                                <div class="spinner hidden" id="spinner"></div>
                                <span id="buttonText"><i class="fa fa-cc-stripe" aria-hidden="true"></i> Pay with
                                    Credit
                                    Card</span>
                            </button>
                        </div>
                        <!-- Cancel Order Button -->
                        <div class="card-cancel-button">
                            <a href="{{ route('monetization.cancel') }}"><button>Cancel Order</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            // Set Stripe publishable key to initialize Stripe.js
            @if (env('STRIPE_TEST') === true)
                const stripe = Stripe('{{ env('STRIPE_PUB_KEY') }}');
            @else
                const stripe = Stripe(
                    '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->stripe_publish_key }}');
            @endif

            // Select payment button
            const payBtn = document.querySelector("#payButton");

            // Payment request handler
            payBtn.addEventListener("click", function(evt) {
                setLoading(true);

                createCheckoutSession().then(function(data) {
                    console.log(data); // Debugging response from the backend
                    if (data.sessionId) {
                        stripe.redirectToCheckout({
                            sessionId: data.sessionId,
                        }).then(handleResult);
                    } else {
                        handleResult(data); // If no session ID, handle the response
                    }
                });
            });

            // Create a Checkout Session with the selected product
            const createCheckoutSession = function() {
                @if (env('STRIPE_TEST') === true)
                    let stripeSecret = '{{ env('STRIPE_SECRET_KEY') }}';
                @else
                    let stripeSecret =
                        '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->stripe_secret_key }}';
                @endif
                return fetch("{{ url('/stripe/purchase') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        createCheckoutSession: 1,
                        stripeSecret: stripeSecret,
                        monetizationAmount: '{{ session('MONETIZATION.amount') }}',
                        monetizationTitle: '{{ session('MONETIZATION.title') }}',
                        monetizationId: '{{ session('MONETIZATION.code') }}',
                    }),
                }).then(function(result) {
                    console.log('Backend response:', result); // Debugging the fetch response
                    return result.json();
                });
            };

            // Handle the result of the checkout process
            const handleResult = function(result) {
                if (result.error) {
                    showMessage(result.error.message);
                }
                setLoading(false);
            };

            // Show a spinner on payment processing
            function setLoading(isLoading) {
                if (isLoading) {
                    // Disable the button and show a spinner
                    payBtn.disabled = true;
                    document.querySelector("#spinner").classList.remove("hidden");
                    document.querySelector("#buttonText").classList.add("hidden");
                } else {
                    // Enable the button and hide spinner
                    payBtn.disabled = false;
                    document.querySelector("#spinner").classList.add("hidden");
                    document.querySelector("#buttonText").classList.remove("hidden");
                }
            }

            // Display message
            function showMessage(messageText) {
                const messageContainer = document.querySelector("#paymentResponse");

                messageContainer.classList.remove("hidden");
                messageContainer.textContent = messageText;

                setTimeout(function() {
                    messageContainer.classList.add("hidden");
                    messageContainer.textContent = "";
                }, 5000);
            }
        </script>
    @endpush
