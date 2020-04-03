<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param array ...$roles
     * @return RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login')->with('fail', 'You must login!');
        }

        if (empty($roles)) {
            return $next($request);
        }

        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }else{
            $path = $request->path();
            if( $path == 'salary/calc/search' && !isset($_POST['name']) && !isset($_POST['member_type']) ){
                return $next($request);
            }
        }

        abort(404);
    }
}