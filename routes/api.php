<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Midtrans Webhook — excluded from CSRF in bootstrap/app.php
Route::post('/midtrans/callback', [\App\Http\Controllers\PaymentController::class, 'handleCallback'])
    ->name('midtrans.callback');
