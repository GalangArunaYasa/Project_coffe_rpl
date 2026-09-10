<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Auth::user();

        if (empty($roles) || in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika user tidak punya akses
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki izin mengakses halaman tersebut.');
        }

        if ($user->isPenjual()) {
            return redirect()->route('penjual.dashboard')->with('error', 'Anda tidak memiliki izin mengakses halaman tersebut.');
        }

        return redirect('/')->with('error', 'Akses ditolak! Halaman ini hanya untuk pengguna dengan hak akses khusus.');
    }
}
