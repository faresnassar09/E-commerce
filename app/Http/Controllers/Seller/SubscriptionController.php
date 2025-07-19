<?php

namespace App\Http\Controllers\Seller;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function createCheckout(Request $request)
    {
        $seller = AuthSeller::fullInfo();

        //delete the old cancelled subscription if exsist
          
        $this->deleteOldSubscriptionIfExists($seller);
 
  
        return $seller->newSubscription('default', 'price_1Rbc1gQB0tWmP4Q3UQXyV6H6')
            ->trialDays(91)
            ->checkout([
                'success_url' => route('seller.subscription.success'),
                'cancel_url' => route('seller.subscription.failed'),
            ]);
    }


    public function getSubscriptionDetails()
    {

        $subscription = AuthSeller::fullInfo()->subscription('default');
        $renewsAt = null;

        if ($subscription && $subscription->active()) {



            \Stripe\Stripe::setApiKey(config('cashier.secret'));

            //cache value because it takes long time to load

            $stripeSub = Cache::remember("stripeSub.{$subscription->stripe_id}", now()->addMinutes(10), function () use ($subscription) {

                return \Stripe\Subscription::retrieve($subscription->stripe_id)->toArray();
            });

            $renewsAt = \Carbon\Carbon::createFromTimestamp($stripeSub['current_period_end']);
        }


        return view('sellers.billing', compact('subscription', 'renewsAt'));
    }



    public function cancel()
    {

        $subscription = AuthSeller::fullInfo()->subscription();

        if (!$subscription || ! $subscription->active()) {

            Log::channel('seller')->error('an error occrred while attemping cancel the subscription',[

                'seller_id' => AuthSeller::id(),
                'stripe_id' => $subscription->stripe_id,

            ]);

            return back()->with('failed', 'حدثت مشكلة اثناء الغاء الاشتراك تواصل مع الدعم');

        }

 $subscription->cancel();

             Log::channel('seller')->error('the subscription has been canceled',[

                'seller_id' => AuthSeller::id(),
                'stripe_id' => $subscription->stripe_id,

            ]);
        return back()->with('success','تم الغاء الاشتراك بنجاح يمكنك سيكون لك وصول حتي انتهاء فترة الاشتراك');
    } 


    private function deleteOldSubscriptionIfExists($seller){


        try{

            $seller->subscriptions()
            ->whereNotNull('ends_at')
            ->where('ends_at', '<=', now())
            ->delete();

        }catch(\Exception $e){


            Log::channel('seller')->error('failed to delete an subscription',[

                'seller_id' => $seller->id,
                'error' => $e->getMessage(),

            ]);

        }


    }
}
  