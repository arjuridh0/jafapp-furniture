<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ActivationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ActivationController extends Controller
{
    /**
     * Activate account via token link.
     */
    public function activate(Request $request, string $token)
    {
        $user = User::where('activation_token', $token)
            ->where('activation_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return view('auth.activate', [
                'success' => false,
                'message' => 'Token aktivasi tidak valid atau sudah kedaluwarsa.',
            ]);
        }

        $user->update([
            'is_guest' => false,
            'is_active' => true,
            'email_verified_at' => now(),
            'activation_token' => null,
            'activation_token_expires_at' => null,
        ]);

        // Auto login after activation
        Auth::login($user);

        return view('auth.activate', [
            'success' => true,
            'message' => 'Akun Anda berhasil diaktivasi! Selamat datang.',
            'user' => $user,
        ]);
    }

    /**
     * Show activation form (for setting password).
     */
    public function showSetPasswordForm(string $token)
    {
        $user = User::where('activation_token', $token)
            ->where('activation_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Token aktivasi tidak valid atau sudah kedaluwarsa.');
        }

        return view('auth.set-password', compact('user', 'token'));
    }

    /**
     * Set password and activate account.
     */
    public function setPassword(Request $request, string $token)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('activation_token', $token)
            ->where('activation_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Token aktivasi tidak valid atau sudah kedaluwarsa.');
        }

        $user->update([
            'password' => $request->password,
            'is_guest' => false,
            'is_active' => true,
            'email_verified_at' => now(),
            'activation_token' => null,
            'activation_token_expires_at' => null,
        ]);

        Auth::login($user);

        return redirect()->route('customer.orders')
            ->with('success', 'Akun berhasil diaktivasi! Password Anda telah diperbarui.');
    }

    /**
     * Resend activation email.
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)
            ->where('is_active', false)
            ->first();

        if (!$user) {
            return back()->with('info', 'Jika email terdaftar, kami telah mengirim ulang email aktivasi.');
        }

        // Generate new token
        $user->update([
            'activation_token' => Str::random(64),
            'activation_token_expires_at' => now()->addDays(7),
        ]);

        try {
            Mail::to($user->email)->queue(new ActivationMail($user));
        } catch (\Throwable) {
            // Silent fail
        }

        return back()->with('success', 'Email aktivasi telah dikirim ulang. Silakan cek inbox Anda.');
    }
}
