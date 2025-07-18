<?php

namespace App\Services;

use Stripe\StripeClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\InvalidRequestException;

class SubscriptionEvent 
{
    /**
     * Resolves the Stripe API secret key based on environment.
     *
     * @return string
     */
    protected function getStripeSecretKey(): string
    {
        return env('STRIPE_TEST') === 'true'
            ? env('STRIPE_SECRET_KEY')
            : AppConfig::get()->app->colors_assets_for_branding->stripe_secret_key;
    }

    /**
     * Resolves the actual Stripe Subscription ID from an input ID (which might be an invoice ID).
     *
     * @param StripeClient $stripe The Stripe client instance.
     * @param string $inputStripeId The ID provided (could be sub_ or in_).
     * @return string The actual Stripe Subscription ID.
     * @throws \Exception If a valid subscription ID cannot be determined.
     */
    protected function resolveSubscriptionId(StripeClient $stripe, string $inputStripeId): string
    {
        try {
            $invoice = $stripe->invoices->retrieve($inputStripeId);

            if (!empty($invoice->subscription)) {
                Log::info("Resolved Stripe subscription ID '{$invoice->subscription}' from invoice '{$inputStripeId}'.");
                return $invoice->subscription;
            } else {
                Log::warning("Invoice '{$inputStripeId}' found, but it has no associated subscription. Assuming input ID is the subscription ID.");
                return $inputStripeId;
            }
        } catch (InvalidRequestException $e) {
            Log::info("Input ID '{$inputStripeId}' is not a valid Stripe Invoice ID. Assuming it's a Subscription ID. Error: " . $e->getMessage());
            return $inputStripeId;
        } catch (\Exception $e) {
            $errorMessage = "Unexpected error while trying to resolve subscription ID for '{$inputStripeId}': " . $e->getMessage();
            Log::error($errorMessage);
            throw new \Exception($errorMessage);
        }
    }

    /**
     * Cancels a Stripe subscription.
     *
     * @param string $inputStripeId The Stripe ID (can be invoice ID or subscription ID).
     * @return string The actual Stripe Subscription ID that was cancelled.
     * @throws \Exception If the subscription cannot be cancelled or determined.
     */
    public function cancelSubscription(string $inputStripeId): string
    {
        $stripe = new StripeClient($this->getStripeSecretKey());
        $actualStripeSubscriptionId = null;

        try {
            $actualStripeSubscriptionId = $this->resolveSubscriptionId($stripe, $inputStripeId);

            if ($actualStripeSubscriptionId) {
                $stripe->subscriptions->cancel($actualStripeSubscriptionId, []);
                Log::info("Stripe subscription '{$actualStripeSubscriptionId}' successfully cancelled.");
                return $actualStripeSubscriptionId;
            } else {
                $errorMessage = "No valid Stripe Subscription ID could be determined for cancellation using input '{$inputStripeId}'.";
                Log::error($errorMessage);
                throw new \Exception($errorMessage);
            }

        } catch (ApiErrorException $e) {
            Log::error("Stripe API error during subscription cancellation for '{$actualStripeSubscriptionId}': " . $e->getMessage());
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = "General error during subscription cancellation for input '{$inputStripeId}': " . $e->getMessage();
            Log::error($errorMessage);
            throw $e;
        }
    }

    /**
     * Pauses a Stripe subscription for a specified number of days.
     *
     * @param string $inputStripeId The Stripe ID (can be invoice ID or subscription ID).
     * @param int $days The number of days to pause the subscription.
     * @return string The actual Stripe Subscription ID that was paused.
     * @throws \Exception If the subscription cannot be paused or determined.
     */
    public function pauseSubscription(string $inputStripeId, int $days): string
    {
        $stripe = new StripeClient($this->getStripeSecretKey());
        $actualStripeSubscriptionId = null;

        try {
            $actualStripeSubscriptionId = $this->resolveSubscriptionId($stripe, $inputStripeId);

            if ($actualStripeSubscriptionId) {
                $resumeAt = Carbon::now()->addDays($days)->timestamp;

                $stripe->subscriptions->update($actualStripeSubscriptionId, [
                    'pause_collection' => [
                        'behavior' => 'void',
                        'resumes_at' => $resumeAt,
                    ],
                ]);

                Log::info("Stripe Subscription '{$actualStripeSubscriptionId}' successfully paused for {$days} days, resuming at " . Carbon::createFromTimestamp($resumeAt)->toDateTimeString() . ".");
                return $actualStripeSubscriptionId;

            } else {
                $errorMessage = "No valid Stripe Subscription ID could be determined for pausing using input '{$inputStripeId}'.";
                Log::error($errorMessage);
                throw new \Exception($errorMessage);
            }

        } catch (ApiErrorException $e) {
            $errorMessage = "Stripe API error during subscription pause for '{$actualStripeSubscriptionId}': " . $e->getMessage();
            Log::error($errorMessage);
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = "General error during subscription pause for input '{$inputStripeId}': " . $e->getMessage();
            Log::error($errorMessage);
            throw $e;
        }
    }

    public function resumeSubscription(string $inputStripeId)
    {
        $stripe = new StripeClient($this->getStripeSecretKey());
        $actualStripeSubscriptionId = null;

        try {
            $actualStripeSubscriptionId = $this->resolveSubscriptionId($stripe, $inputStripeId);

            if ($actualStripeSubscriptionId) {
                $stripe->subscriptions->update($actualStripeSubscriptionId, [
                    'pause_collection' => null,
                ]);
                Log::info("Stripe subscription '{$actualStripeSubscriptionId}' successfully resumed.");
                return $actualStripeSubscriptionId;
            } else {
                $errorMessage = "No valid Stripe Subscription ID could be determined for resuming using input '{$inputStripeId}'.";
                Log::error($errorMessage);
                throw new \Exception($errorMessage);
            }
        } catch (ApiErrorException $e) {
            $errorMessage = "Stripe API error during subscription resume for '{$actualStripeSubscriptionId}': " . $e->getMessage();
            Log::error($errorMessage);
        } catch (\Exception $e) {
            $errorMessage = "General error during subscription resume for input '{$inputStripeId}': " . $e->getMessage();
            Log::error($errorMessage);
            throw $e;
        }
    }
}