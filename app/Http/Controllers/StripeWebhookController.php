<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyStripeWebhookSecret;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class StripeWebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifyStripeWebhookSecret::class);
    }

    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $method = 'handle' . Str::studly(str_replace('.', '_', $payload['type']));

        if (method_exists($this, $method)) {
            return $this->{$method}($payload);
        }
    }

    protected function handlePaymentIntentSucceeded($payload)
    {
        $user = User::findOrFail(Arr::get($payload, 'data.object.metadata.user_id'));

        $user->update([
            'member' => true
        ]);
    }
}
