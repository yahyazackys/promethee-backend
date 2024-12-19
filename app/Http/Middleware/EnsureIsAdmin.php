<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::check()) {
        if (Auth::user()->role == '0') {
            return $next($request);
        } else {
            return redirect('/');
        }
        // } else {
        //     return redirect('/')->with('status', ' please login first');
        // }
        // if ($request->user() && $request->user()->role === '1') {
        //     // Jika pengguna memiliki peran yang dilarang, alihkan atau beri respons yang sesuai
        //     return redirect('/'); // Ganti dengan halaman yang sesuai
        // }
    }
}
