<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckVerification
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->is_verified) {
            // Logout user yang belum terverifikasi
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('otp.verification')
                ->with('error', 'Akun Anda belum terverifikasi. Silakan verifikasi dengan kode OTP.')
                ->with('email', Auth::user()->email);
        }

        return $next($request);
    }
}
