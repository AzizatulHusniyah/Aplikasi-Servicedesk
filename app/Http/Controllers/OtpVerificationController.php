<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\OtpVerificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    public function showVerificationForm(Request $request)
    {
        $email = $request->session()->get('otp_email') ?? $request->query('email');

        if (!$email) {
            return redirect()->route('register')
                ->with('error', 'Sesi verifikasi telah berakhir. Silakan daftar ulang.');
        }

        return view('auth.otp-verification', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6'
        ]);

        \Log::info("OTP verification attempt for: {$request->email} with code: {$request->otp_code}");

        try {
            $user = User::where('email', $request->email)
                        ->where('is_verified', false)
                        ->first();

            if (!$user) {
                \Log::warning("User not found or already verified: {$request->email}");
                return back()->withErrors([
                    'otp_code' => 'User tidak ditemukan atau sudah terverifikasi.'
                ])->withInput();
            }

            // Debug: Log OTP data
            \Log::debug("OTP data for {$user->email}: code={$user->otp_code}, expires_at={$user->otp_expires_at}");

            if ($user->verifyOtp($request->otp_code)) {
                \Log::info("OTP verified successfully for: {$user->email}");

                // Login user secara otomatis setelah verifikasi
                Auth::login($user);

                // Clear session
                $request->session()->forget('otp_email');

                return redirect()->route('dashboard')
                    ->with('success', 'Verifikasi berhasil! Selamat datang di sistem.');
            }

            \Log::warning("OTP verification failed for: {$user->email}");
            return back()->withErrors([
                'otp_code' => 'Kode OTP tidak valid atau telah kedaluwarsa.'
            ])->withInput();

        } catch (\Exception $e) {
            \Log::error("OTP verification error for {$request->email}: " . $e->getMessage());

            return back()->withErrors([
                'otp_code' => 'Terjadi kesalahan sistem. Silakan coba lagi atau minta kode OTP baru.'
            ])->withInput();
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        \Log::info("OTP resend requested for: {$request->email}");

        try {
            $user = User::where('email', $request->email)
                        ->where('is_verified', false)
                        ->first();

            if (!$user) {
                \Log::warning("Resend OTP failed - user not found: {$request->email}");
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan atau sudah terverifikasi.'
                ], 400);
            }

            // Generate OTP baru
            $otp = $user->generateOtp();

            try {
                Mail::to($user->email)->send(new OtpVerificationMail($otp, $user));
                \Log::info("OTP resent successfully to: {$user->email}");

                return response()->json([
                    'success' => true,
                    'message' => 'Kode OTP baru telah dikirim ke email Anda.'
                ]);
            } catch (\Exception $e) {
                \Log::error("Failed to resend OTP to {$user->email}: " . $e->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim OTP. Silakan coba lagi.'
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error("Resend OTP error for {$request->email}: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }
}
