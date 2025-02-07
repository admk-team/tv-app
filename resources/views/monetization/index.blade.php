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
            width: 320px !important;
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
    @php
        $ARR_MONE_MSG = [
            'P' => 'Pay Per View / Rental',
            'O' => 'Life Time Access',
            'S' => 'Subscription Based',
            'ES' => 'Early Screening Membership',
            'E' => 'Season Wise Pay',
        ];
        // $typeStr = \App\Services\AppConfig::get()->app->keys_description->MONETIZATION_TYPES;
        // $types = explode(',', $typeStr);

        // for ($i = 0; $i < sizeof($types); $i++) {
        //     $type = explode(':', $types[$i]);
        //     $types[trim($type[0])] = trim($type[1]);
        //     unset($types[$i]);
        // }
        // $period = $planData['PLAN_PERIOD'] ?? null;
        // if (($planData['PLAN'] ?? null) > 1) {
        //     $period .= 's';
        // }
    @endphp

    <section>
        <div class="container mt-0">
            <div class="row">
                <div class="card px-0">
                    <div class="card-header">
                        @if (isset($planData['SUBS_TYPE']) && $planData['SUBS_TYPE'] != 'S' && $planData['SUBS_TYPE'] != 'ES')
                            <img src="{{ $planData['POSTER'] }}" class="img-thumbnail"
                                alt="{{ $planData['PAYMENT_INFORMATION'] }}">
                        @else
                            <img src="{{ asset('assets/images/plan.jpg') }}" class="img-thumbnail" alt="<?php echo $planData['PAYMENT_INFORMATION']; ?>">
                        @endif
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-uppercase">Order Summary</h4>
                        <div id="paymentResponse" class="hidden"></div>
                        <div>
                            <pre id="token_response"></pre>
                        </div>
                        <div class="card-title">{{ $planData['PAYMENT_INFORMATION'] }}</div>
                        <div class="card-text ">
                            <p><b>Plan Type: </b> {{ $ARR_MONE_MSG[$planData['SUBS_TYPE']] }}</p>
                            <p><b>Plan Validity: </b> {{ $planData['PLAN'] }}</p>
                            @if (isset($planData['RECIPIENT_EMAIL']))
                                <p><b>Gift Email: </b> {{ $planData['RECIPIENT_EMAIL'] }}</p>
                            @endif

                        </div>
                        <div class="card-plan">
                            <div class="card-plan-img"><img src="{{ asset('assets/images/icons/buy.png') }}" alt="">
                            </div>

                            <div class="card-plan-text">
                                <div class="card-plan-title">Amount</div>
                                <div class="card-plan-price">
                                    @if (($planData['PLAN_TYPE'] ?? false) == 'T')
                                        Free
                                    @else
                                        ${{ $planData['AMOUNT'] }}
                                    @endif
                                </div>
                            </div>
                            <div class="card-plan-link"><a href="{{ session('REDIRECT_TO_SCREEN') }}">Change</a></div>
                        </div>

                        {{-- Apply Coupon --}}
                        @if (!session('coupon_applied'))
                            <div class="mt-4">
                                <form action="{{ url('/apply-coupon') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control text-black" name="coupon_code"
                                            placeholder="Enter Coupon Code" required>
                                        <button type="submit" class="btn btn-secondary" type="button"
                                            id="button-addon2">Apply</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        @if (session()->has('coupon_applied_success'))
                            <div class="mt-4 text-success text-center">
                                <strong>{{ session()->get('coupon_applied_success') }}</strong>
                            </div>
                        @endif

                        @if (session()->has('coupon_applied_error') || true)
                            <div class="mt-2 text-danger text-center">
                                <strong>{{ session()->get('coupon_applied_error') }}</strong>
                            </div>
                        @endif

                        <div class="card-payment-button">
                            <form
                                action="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->PAYPAL_SANDBOX == 'true' ? env('PAYPAL_SANDBOX_URL') : env('PAYPAL_URL') }}"
                                method="POST">
                                <input type="hidden" name="business"
                                    value="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->PAYPAL_ID }}">
                                @if (isset($planData['PAYPAL_PLAN_ID']) && $planData['PAYPAL_PLAN_ID'])
                                    <!-- Specify a Subscribe button. -->
                                    <input type="hidden" name="cmd" value="_xclick-subscriptions" />

                                    <!-- Identify the subscription -->
                                    <input type="hidden" name="item_name" value="{{ $planData['PAYPAL_PLAN_NAME'] }}" />
                                    <input type="hidden" name="item_number" value="{{ $planData['PAYPAL_PLAN_ID'] }}" />

                                    @if (isset($planData['PAYPAL_PLAN_TRAIL']) &&
                                            $planData['PAYPAL_PLAN_TRAIL'] &&
                                            $planData['PAYPAL_PLAN_TRAIL'] !== '' &&
                                            $planData['PAYPAL_PLAN_TRAIL'] > 0)
                                        <!-- Trial period parameters -->
                                        <input type="hidden" name="a1" value="0" /> <!-- Trial amount (free) -->
                                        <input type="hidden" name="p1"
                                            value="{{ $planData['PAYPAL_PLAN_TRAIL'] }}" />
                                        <input type="hidden" name="t1" value="D" />
                                        <!-- Trial period duration (7 days) -->
                                    @endif

                                    <!-- Regular subscription parameters -->
                                    <input type="hidden" name="a3" value="{{ $planData['PAYPAL_PLAN_PRICE'] }}" />
                                    <!-- Regular payment amount -->
                                    <input type="hidden" name="p3" value="1" />
                                    <!-- Number of billing cycles (1 for monthly) -->
                                    <input type="hidden" name="t3" value="{{ $planData['PAYPAL_PLAN_DURATION'] }}" />
                                    <!-- Recurring period (monthly) -->
                                @else
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="item_name" value="{{ $planData['PAYMENT_INFORMATION'] }}">
                                    <input type="hidden" name="item_number" value="{{ $planData['MONETIZATION_GUID'] }}">

                                    <input type="hidden" name="subs_type" value="{{ $planData['SUBS_TYPE'] }}">
                                    <input type="hidden" name="monetization_type"
                                        value="{{ $planData['MONETIZATION_TYPE'] }}">
                                    <input type="hidden" name="amount" value="{{ $planData['AMOUNT'] }}">
                                @endif
                                @if (isset($planData['RECIPIENT_EMAIL']))
                                    <input type="hidden" name="gift_recipient_email"
                                        value="{{ $planData['RECIPIENT_EMAIL'] }}">
                                @endif
                                <input type="hidden" name="rm" value="2">
                                <input type="hidden" name="currency_code"
                                    value="{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->payment_currency_code }}">
                                <input type="hidden" name="return" value="{{ url('/monetization/success') }}">
                                <input type="hidden" name="cancel_return" value="{{ url('/monetization/cancel') }}">
                                @if (
                                    ($planData['PLAN_TYPE'] ?? null) != 'T' &&
                                        \App\Services\AppConfig::get()->app->colors_assets_for_branding->is_paypal_payment_active == 'true' &&
                                        $planData['AMOUNT'] > 0)
                                    <button type="submit" class="btn paypal_btn"><i class="fa-brands fa-cc-paypal"
                                            aria-hidden="true"></i>
                                        Pay with Paypal</button>
                                @endif
                                @if (($planData['PLAN_TYPE'] ?? false) == 'T' || $planData['AMOUNT'] <= 0)
                                    <a href="{{ route('free-subscription') }}"
                                        class="mt-2 w-100 btn btn-lg btn-primary">Get
                                        Free Access</a>
                                @else
                                    <button class="stripe-button mt-2" id="payButton">
                                        <div class="spinner hidden" id="spinner"></div>
                                        <span id="buttonText"><i class="fa-brands fa-cc-stripe" aria-hidden="true"></i> Pay with
                                            Credit
                                            Card</span>
                                    </button>
                                @endif
                            </form>
                        </div>
                        <div class="card-cancel-button">
                            <a href="{{ route('monetization.cancel') }}"><button>Cancel Order</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

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
                if (data.sessionId) {
                    stripe.redirectToCheckout({
                        sessionId: data.sessionId,
                    }).then(handleResult);
                } else {
                    handleResult(data);
                }
            });
        });

        // Create a Checkout Session with the selected product
        const createCheckoutSession = function(stripe) {
            @if (env('STRIPE_TEST') === true)
                let stripeSecret = '{{ env('STRIPE_SECRET_KEY') }}';
            @else
                let stripeSecret =
                    '{{ \App\Services\AppConfig::get()->app->colors_assets_for_branding->stripe_secret_key }}';
            @endif
            return fetch("{{ url('/stripe/checkout') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    createCheckoutSession: 1,
                    stripeSecret
                }),
            }).then(function(result) {
                return result.json();
            });
        };

        // Handle any errors returned from Checkout
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
                messageText.textContent = "";
            }, 5000);
        }
    </script>
@endpush
