<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedStudent
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // ALLOW ADMIN USERS TO BYPASS VERIFICATION
        if ($user && $user->is_admin == 1) {
            return $next($request);
        }

        // FOR REGULAR USERS - CHECK IF ID IS APPROVED
        if (! $user || $user->id_verification_status !== 'approved') {
            return redirect()->route('id-verification.show')
                ->with('error', 'You must verify your student ID to access this feature.');
        }

        return $next($request);
    }
}
