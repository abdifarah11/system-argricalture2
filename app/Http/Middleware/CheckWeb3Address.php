<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckWeb3Address
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('web3_address')) {
            return redirect()->route('web3.login');
        }
        return $next($request);
    }
}
