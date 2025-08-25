<?php

namespace App\Services\Seller;

use Illuminate\Support\Facades\Cache;

class SubscriptionService{



    public function deleteOldSubscriptionIfExists($seller){

        $seller->subscriptions()
        ->whereNotNull('ends_at')
        ->where('ends_at', '<=', now())
        ->delete();

    }


    public function applySubscription($seller) {

        return $seller->newSubscription('default', 'price_1Rbc1gQB0tWmP4Q3UQXyV6H6')
        ->trialDays(91)
        ->checkout([
            'success_url' => route('seller.subscription.success'),
            'cancel_url' => route('seller.subscription.failed'),
        ]);
    }

    public function subscriptionDeadline($subscription) {

        \Stripe\Stripe::setApiKey(config('cashier.secret'));

        //cache value because it takes long time to load

        $stripeSub = Cache::remember("stripeSub.{$subscription->stripe_id}", now()->addMinutes(10), function () use ($subscription) {

            return \Stripe\Subscription::retrieve($subscription->stripe_id)->toArray();
        });

        return \Carbon\Carbon::createFromTimestamp($stripeSub['current_period_end']);
        
    }

    public function cancelSubscription($subscription) {
        
        $subscription->cancel();

    }

}