<?php

namespace App\Http\Middleware;

use App\Http\Controllers\BaseController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // Check if user is authenticated and has the required permission
        if (!$request->user() || !$request->user()->hasPermissionTo($permission)) {

            // If it's an AJAX request, return a JSON error response
            if ($request->ajax()) {
                return app(BaseController::class)->sendError('permission.error', [
                    'error'=>'Forbidden: You do not have permission.'
                ], Response::HTTP_FORBIDDEN);
            }
            // Otherwise, abort with a 403 Forbidden error
            abort(Response::HTTP_FORBIDDEN, 'Forbidden: You do not have permission.');
        }

        return $next($request);
    }
}
