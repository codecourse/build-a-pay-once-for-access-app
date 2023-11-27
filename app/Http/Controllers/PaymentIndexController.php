<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfMember;
use Illuminate\Http\Request;

class PaymentIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', RedirectIfMember::class]);
    }

    public function __invoke(Request $request)
    {
        if (!session()->has('payment_intent_id')) {
            $paymentIntent = app('stripe')->paymentIntents->create([
                'amount' => 10000,
                'currency' => 'usd',
                'setup_future_usage' => 'on_session',
                'metadata' => [
                    'user_id' => (string) $request->user()->id
                ]
            ]);

            session()->put('payment_intent_id', $paymentIntent->id);
        } else {
            $paymentIntent = app('stripe')->paymentIntents->retrieve(session()->get('payment_intent_id'));
        }

        return view('payments.index', [
            'paymentIntent' => $paymentIntent
        ]);
    }
}
