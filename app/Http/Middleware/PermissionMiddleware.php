<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Permission;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // Cek jika user tidak login
        if (!auth()->check()) {
            abort(403, 'Unauthorized action.');
        }

        // Cek jika permission exists, jika tidak auto-create (untuk development)
        if (!Permission::where('name', $permission)->where('guard_name', 'web')->exists()) {
            // Untuk development, auto-create permission yang missing
            if (app()->environment('local')) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
            } else {
                // Untuk production, log error dan abort
                \Log::error("Permission not found: {$permission}");
                abort(500, 'Permission configuration error.');
            }
        }

        // Cek jika user memiliki permission
        if (!auth()->user()->hasPermissionTo($permission)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
