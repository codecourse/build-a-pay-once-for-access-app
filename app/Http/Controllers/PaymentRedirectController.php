<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentRedirectController extends Controller
{
    public function __invoke()
    {
        return redirect('/dashboard')->withStatus('Payment accepted');
    }
}
