<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;

class EnsureDoctorApproved
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->role === UserRole::Doctor && $user->approved_at === null) {
            abort(403, 'Account awaiting approval.');
        }

        return $next($request);
    }
}
