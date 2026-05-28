<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key
    |--------------------------------------------------------------------------
    | Server key dari Midtrans Dashboard. Digunakan untuk backend API calls
    | dan verifikasi signature webhook.
    */
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key
    |--------------------------------------------------------------------------
    | Client key dari Midtrans Dashboard. Digunakan di frontend untuk
    | menginisiasi Snap.js payment popup.
    */
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Production Mode
    |--------------------------------------------------------------------------
    | Set true untuk production, false untuk sandbox/testing.
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitized Mode
    |--------------------------------------------------------------------------
    | Jika true, Midtrans akan melakukan sanitasi input.
    */
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    /*
    |--------------------------------------------------------------------------
    | 3D Secure
    |--------------------------------------------------------------------------
    | Aktifkan 3D Secure untuk keamanan tambahan pada pembayaran kartu kredit.
    */
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];
