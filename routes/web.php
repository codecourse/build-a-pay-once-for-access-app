<?php

use App\Http\Controllers\MemberIndexController;
use App\Http\Controllers\PaymentIndexController;
use App\Http\Controllers\PaymentRedirectController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Middleware\RedirectIfNotMember;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/payments', PaymentIndexController::class);
Route::post('/payments/redirect', PaymentRedirectController::class)
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::middleware([RedirectIfNotMember::class])->group(function () {
    Route::get('/members', MemberIndexController::class);
});

Route::post('/webhooks/stripe', StripeWebhookController::class);

require __DIR__.'/auth.php';
