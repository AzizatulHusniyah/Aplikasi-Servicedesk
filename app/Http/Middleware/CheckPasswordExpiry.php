<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if ($user && $user->isPasswordExpired() && $user->hasAnyRole(['administrator', 'teknisi', 'eselon'])) {
            if (!$request->is('profile*') && !$request->is('logout')) {
                return redirect()->route('profile.edit')
                    ->with('error', 'Password Anda telah kadaluarsa. Silakan ubah password terlebih dahulu.');
            }
        }

        return $next($request);
    }
}