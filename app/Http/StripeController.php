<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function subscribe(Request $request)
    {
        $user = $request->user();
        $paymentMethod = $request->input('payment_method'); // Set this with client-side Stripe.js
        $user->newSubscription('default', 'price_id')->create($paymentMethod);

        return redirect('/home')->with('status', 'Subscription successful!');
    }
}
