<?php

namespace App\Http\Middleware;

use App\Constants\User\Status;
use Closure;

class ApprovedOnly
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
        if (auth()->check() && auth()->user()->status !== Status::ENABLED) {
            auth()->logout();
            return redirect()->route('login')->with('message', __('auth.not_approved'));
        }

        return $next($request);
    }
}
