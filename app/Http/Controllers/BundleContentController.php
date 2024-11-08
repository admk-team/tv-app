<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Services\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Price;

class BundleContentController extends Controller
{
    public function index(Request $request, $code)
    {
        $response = Http::withHeaders(Api::headers())
            ->get(Api::endpoint('/content-bundle/' . $code));

        $responseJson = $response->json();

        if (!isset($responseJson['bundleContent']) || !isset($responseJson['relatedStreams'])) {
            return response()->json(['error' => 'Invalid response structure from API'], 500);
        }
        $bundleContent = $responseJson['bundleContent'];
        if (empty($bundleContent)) {
            return response()->json(['error' => 'Content bundle not found'], 404);
        }
        $relatedStreams = $responseJson['relatedStreams'];
        if (empty($relatedStreams)) {
            return response()->json(['error' => 'No related streams found for this bundle'], 404);
        }
        $formattedRelatedStreams = [];
        foreach ($relatedStreams as $stream) {
            $formattedRelatedStreams[] = [
                'code' => $stream['code'] ?? '',
                'title' => $stream['title'] ?? '',
                'short_description' => $stream['short_description'] ?? '',
                'poster' => $stream['poster'] ?? '',
                'duration' => $stream['duration'] ?? '',
                'language' => collect($stream['language'] ?? [])->map(function ($language) {
                    return [
                        'code' => $language['code'] ?? '',
                        'title' => $language['title'] ?? ''
                    ];
                })->toArray(),
                'genre' => collect($stream['genres'])->map(function ($genre) {
                    return [
                        'code' => $genre['code'] ?? '',
                        'title' => $genre['title'] ?? ''
                    ];
                })->toArray(),
                'ratings' => collect($stream['ratings'])->map(function ($rating) {
                    return [
                        'code' => $rating['code'] ?? '',
                        'title' => $rating['title'] ?? ''
                    ];
                })->toArray(),
                'qualities' => collect($stream['qualities'])->map(function ($quality) {
                    return [
                        'code' => $quality['code'] ?? '',
                        'title' => $quality['title'] ?? ''
                    ];
                })->toArray(),
            ];
        }

        // Step 8: Prepare the final response
        $data = [
            'bundleContent' => $bundleContent,
            'relatedStreams' => $formattedRelatedStreams,
        ];
        return view('content_bundle.index', compact('data'));
    }
    public function purchase(Request $request)
    {
        if (!isset(session('USER_DETAILS')['USER_CODE'])) {
            return redirect()->route('login');
        }

        $planData = [
            'amount' => $request->input('bundleContent.amount'),
            'title' => $request->input('bundleContent.title'),
            'code' => $request->input('bundleContent.code'),
            'description' => $request->input('bundleContent.description'),
            'relatedStreams' => collect($request->input('relatedStreams'))->map(function ($stream) {
                return [
                    'title' => $stream['title'],
                    'poster' => $stream['poster'],
                ];
            })->toArray(),
        ];
        session()->put('MONETIZATION', $planData);

        return view('monetization.bundle_index', compact('planData'));
    }
    public function createCheckoutSession(Request $request)
    {
        $api_error = null;
        $stripeSecret = $request->stripeSecret;
        Stripe::setApiKey($stripeSecret);
        $stripeAmount = round(session('MONETIZATION')['amount'] * 100, 2);
        try {
            $checkout_session = Session::create([
                'line_items' => [[
                    'price_data' => [
                        'product_data' => [
                            'name' => session('MONETIZATION')['title']
                        ],
                        'unit_amount' => $stripeAmount,
                        'currency' => \App\Services\AppConfig::get()->app->colors_assets_for_branding->payment_currency_code,
                    ],
                    'quantity' => 1
                ]],
                'mode' => 'payment',
                'success_url' => url('/bundle/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/monetization/cancel'),
            ]);
        } catch (\Exception $e) {
            $api_error = $e->getMessage();
        }
        if (empty($api_error) && $checkout_session) {
            return response()->json([
                'status' => 1,
                'message' => 'Checkout Session created successfully!',
                'sessionId' => $checkout_session->id
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'error' => [
                    'message' => 'Checkout Session creation failed! ' . $api_error
                ]
            ]);
        }
    }


    // Success page logic
    public function success(Request $request)
    {
        if ($request->query('session_id')) {
            $stripeSecretKey = env('STRIPE_SECRET_KEY');
            \Stripe\Stripe::setApiKey($stripeSecretKey);
            $sessionId = $request->query('session_id');
            $checkoutSession = \Stripe\Checkout\Session::retrieve($sessionId);
            $transactionId = $checkoutSession->payment_intent;
            $paidAmount = $checkoutSession->amount_total / 100;
        } elseif ($request->query('tx')) {

            $transactionId = $request->query('tx');
            $paidAmount = $request->query('amt');
        } else {
            // return redirect()->route('error')->with('error', 'Invalid payment source');
        }
        $response = Http::timeout(300)->withHeaders(Api::headers([
            'husercode' => session('USER_DETAILS')['USER_CODE']
        ]))
            ->asForm()
            ->post(Api::endpoint('/sendpaymentdetails'), [
                'transactionId' => $transactionId,
                'requestAction' => 'sendPaymentInfo',
                'amount' => $paidAmount,
                'monetizationGuid' => session('MONETIZATION')['code'],
                'subsType' => 'BC',
                'gift_recipient_email' => null,
                'paymentInformation' => "BUNDLE CONTENT",
            ]);

        $responseJson = $response->json();


        return view('monetization.bundle_success', compact('transactionId', 'responseJson'));
    }


    // Cancel page logic
    public function cancel()
    {
        return view('stripe.cancel');
    }
}
