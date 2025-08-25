<?php

namespace App\Http\Controllers\Seller;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Services\Seller\LoggingService;
use App\Services\Seller\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

        public function __construct(

        public SubscriptionService $subscriptionService,
        public LoggingService $loggingService,
    ) {}

    public function createCheckout(Request $request)
    {

        try {

            $seller = AuthSeller::fullInfo();

            $this->subscriptionService->deleteOldSubscriptionIfExists($seller);

            $this->subscriptionService->applySubscription($seller);

            $this->loggingService->success('seller subscriped successfully', []);

        } catch (\Exception $e) {


            $this->loggingService->failed('Unexpected error occyrred while complite subscription', [

            $e->getMessage(),

            ]);

            return back('failed', __('notifications.subscription_process_failed'));
        }
    }

    public function getSubscriptionDetails()
    {

        $subscription = AuthSeller::fullInfo()->subscription();
        $renewsAt = null;

        if ($subscription && $subscription->active()) {

            $renewsAt = $this->subscriptionService->subscriptionDeadline($subscription);
        }

        return view('sellers.billing', compact('subscription', 'renewsAt'));
    }

    public function cancel()
    {

        $subscription = AuthSeller::fullInfo()->subscription();

        if (!$subscription || ! $subscription->active()) {

            $this->loggingService->failed('an error occrred while attemping cancel the subscription', [

                substr($subscription->stripe_id, -6),
            ]);

            return back()->with('failed',__('notifications.subscription_cancelation_failed'));
        }

        $this->subscriptionService->cancelSubscription($subscription);

        $this->loggingService->failed('the subscription has been canceled', [

            substr($subscription->stripe_id, -6),
        ]);
        return back()->with('success',__('notifications.subscription_canceled_successfully') );
    }
}
