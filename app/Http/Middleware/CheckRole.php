<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        // Check kung naka-login ang user
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Kunin ang role ng current user
        $userRole = strtolower(trim($request->user()->role ?? ''));

        // Check kung authorized ang role
        $allowedRoles = array_map(
            fn ($role) => strtolower(trim($role)),
            $roles
        );

        if (!in_array($userRole, $allowedRoles, true)) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }
}
