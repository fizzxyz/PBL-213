<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // Pecah peran berdasarkan pipe "|" jika hanya satu string masuk
        if (count($roles) === 1 && str_contains($roles[0], '|')) {
            $roles = explode('|', $roles[0]);
        }

        if (method_exists($user, 'hasAnyRole') && $user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized. You do not have the required role.');
    }

}