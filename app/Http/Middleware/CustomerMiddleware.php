<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check()) {
        // Not logged in → send to login page
        return redirect()->route('customer.login')->with('error', 'Please log in to continue.');
    }

    // Optional: check user role (assuming you have a `role` column)
    if (auth()->user()->role !== 'customer') {
        // User is not a customer → deny access
        abort(403, 'Access denied.');
    }

    return $next($request);
}

}
