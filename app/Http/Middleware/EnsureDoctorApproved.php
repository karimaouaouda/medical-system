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

        $routes = [
            'filament.doctor.pages.waiting-approving',
            'filament.doctor.auth.logout',
            'filament.doctor.auth.login',
            'filament.doctor.auth.register',
        ];

        if (
            $user &&
            $user->role === UserRole::Doctor &&
            $user->approved_at === null &&
            !$request->route()->named(...$routes)
        ) {
            return redirect(route('filament.doctor.pages.waiting-approving'));
        }

        return $next($request);
    }
}
