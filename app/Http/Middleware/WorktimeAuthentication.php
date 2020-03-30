<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use App\Constants;

class WorktimeAuthentication
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login')->with('fail', 'You must login!');
        }

        $user = Auth::user();
        if(
            ($request->target !== null && $user->role == Constants::USER_ROLE_MEMBER)
            || ($request->userId !== null && $request->userId != $user->id && $user->role == Constants::USER_ROLE_MEMBER)
            ) abort(404);

        return $next($request);
    }
}