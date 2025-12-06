<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpVerificationMail;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/otp-verification';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Override show registration form
     */
    public function showRegistrationForm()
    {
        \Log::info('=== REGISTER FORM DISPLAYED ===');
        
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', 
                'string', 
                'min:8', 
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'no_whatsapp' => ['nullable', 'string', 'max:15'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Alamat email wajib diisi',
            'email.email' => 'Format alamat email tidak valid',
            'email.unique' => 'Alamat email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.regex' => 'Password harus mengandung minimal 1 huruf kapital, 1 angka, dan 1 karakter khusus (@$!%*?&)',
            'no_whatsapp.max' => 'Nomor WhatsApp maksimal 15 digit',
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'no_whatsapp' => $data['no_whatsapp'] ?? null,
            'role_requested' => 'user',
            'is_verified' => false,
        ]);

        // Generate dan kirim OTP
        $otp = $user->generateOtp();

        try {
            Mail::to($user->email)->send(new OtpVerificationMail($otp, $user));
            \Log::info("OTP email sent successfully to: {$user->email}");
        } catch (\Exception $e) {
            \Log::error("Failed to send OTP email to {$user->email}: " . $e->getMessage());
            // Tetap lanjutkan proses meski email gagal dikirim
        }

        // Berikan role 'user' secara otomatis
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $user->assignRole($userRole);
        }

        \Log::info("User registered successfully (pending OTP): {$user->email}");

        return $user;
    }

    // Override method untuk redirect ke halaman OTP verification
    public function registered(Request $request, $user)
    {
        // Simpan email di session untuk OTP verification
        $request->session()->put('otp_email', $user->email);

        return redirect()->route('otp.verification')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk kode OTP.')
            ->with('email', $user->email);
    }

    /**
     * Override register method tanpa security code
     */
    public function register(Request $request)
    {
        try {
            \Log::info("=== REGISTRATION ATTEMPT ===");
            \Log::info("Request data: " . json_encode($request->except('password', 'password_confirmation')));

            // Validasi data form
            $validator = $this->validator($request->all());
            
            if ($validator->fails()) {
                \Log::warning("Validation failed: " . json_encode($validator->errors()->all()));
                
                return redirect()->back()
                    ->withInput($request->except('password', 'password_confirmation'))
                    ->withErrors($validator);
            }

            // Create user
            $user = $this->create($request->all());

            // Login user dan redirect ke OTP verification
            $this->guard()->login($user);

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());

        } catch (\Exception $e) {
            \Log::error("Registration error: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            $errorMessage = 'Terjadi kesalahan sistem. Silakan coba lagi.';
            
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => $errorMessage]);
        }
    }
}