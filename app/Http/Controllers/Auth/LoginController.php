<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'security_code' => 'required|string|size:6',
        ], [
            'security_code.required' => 'Kode keamanan wajib diisi',
            'security_code.size' => 'Kode keamanan harus 6 karakter',
        ]);
    }

    /**
     * Override show login form
     */
    public function showLoginForm()
    {
        // Generate security code untuk login
        $securityCode = $this->generateSecurityCode();
        
        \Log::info('=== LOGIN FORM DISPLAYED ===');

        return view('auth.login', compact('securityCode'));
    }

    /**
     * Generate security code 6 karakter
     */
    private function generateSecurityCode()
    {
        $securityCode = strtoupper(Str::random(6));
        
        // Simpan di cache dengan expiry 10 menit
        Cache::put('security_code_' . $securityCode, true, 600);
        
        return $securityCode;
    }

    /**
     * Verify security code
     */
    private function verifySecurityCode($code)
    {
        $key = 'security_code_' . strtoupper($code);
        $isValid = Cache::get($key, false);
        
        // Hapus kode setelah digunakan
        if ($isValid) {
            Cache::forget($key);
        }
        
        return $isValid;
    }

    /**
     * Override login method untuk validasi security code
     */
    public function login(Request $request)
    {
        // Validasi security code terlebih dahulu
        $securityCode = $request->input('security_code');
        
        if (!$this->verifySecurityCode($securityCode)) {
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'security_code' => 'Kode keamanan tidak valid atau sudah kadaluarsa',
                ]);
        }

        // Jika security code valid, lanjutkan proses login biasa
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}