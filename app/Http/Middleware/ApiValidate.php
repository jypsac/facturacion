<?php

namespace App\Http\Middleware;

use Closure;

class ApiValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
  {
    if (! $request->expectsJson()) {
            return redirect()->route('login');
        }

    return $next($request);
  }
}
