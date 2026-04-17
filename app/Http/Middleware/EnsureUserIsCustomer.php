<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->isCustomer()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('status', 'Akun admin diarahkan ke dashboard admin.');
        }

        return $next($request);
    }
}
