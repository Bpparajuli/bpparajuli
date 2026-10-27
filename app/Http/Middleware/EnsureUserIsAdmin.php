<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            if (Auth::check()) {
                abort(403, 'You do not have access to the admin area.');
            }

            return redirect()->guest(route('login'));
        }

        return $next($request);
    }
}
