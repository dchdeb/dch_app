<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     * Check if user has any access to the module based on route name pattern.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $module  The module name (e.g., 'opd', 'ipd', 'pharmacy')
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Super admin has all access
        if (auth()->user()->hasRole('super-admin')) {
            return $next($request);
        }

        // Check if user has any permission for this module
        $permissions = [
            "{$module}.view",
            "{$module}.create",
            "{$module}.edit",
            "{$module}.delete",
            "{$module}.print",
            "{$module}.export",
            "{$module}.approve",
        ];

        $hasAccess = false;
        foreach ($permissions as $permission) {
            if (auth()->user()->can($permission)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(403, ' এই মডিউল অ্যাক্সেস করার অনুমতি নেই।');
        }

        return $next($request);
    }
}
