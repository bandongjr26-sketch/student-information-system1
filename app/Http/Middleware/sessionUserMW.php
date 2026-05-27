<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\UserAccounts;

class sessionUserMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Session::get('user');

        if (empty($user)) {
            return redirect('/');
        }

        $role = strtolower((string) Session::get('logged_role'));
        $roles = array_map('strtolower', $roles);

        $account = UserAccounts::find(Session::get('logged_id'));
        $mustChangePassword = $account
            && (bool) $account->must_change_password
            && in_array($role, ['student', 'teacher']);

        if (
            $mustChangePassword
            && ! $request->routeIs('password.change')
            && ! $request->routeIs('password.update')
            && ! $request->routeIs('logout')
        ) {
            Session::put('must_change_password', true);

            return redirect()->route('password.change');
        }

        if (! empty($roles) && ! in_array($role, $roles)) {
            return redirect()->route('dashboard');
        }

        $response = $next($request);

        if (method_exists($response, 'headers')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;

    }
}
