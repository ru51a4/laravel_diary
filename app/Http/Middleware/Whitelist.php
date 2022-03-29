<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Whitelist
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $diary = $request->route('diary');
        $user = Auth::user();
        if ($diary->whitelist && $user->id !== $diary->user->id) {
            if ($diary->usersWhiteList->contains($user)) {
                return $next($request);
            } else {
                return redirect("/home");
            }
        } else {
            return $next($request);
        }
    }
}
