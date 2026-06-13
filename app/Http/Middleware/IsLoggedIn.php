<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsLoggedIn
{
    /**
     * Validate the request against the shared login service (login.ltvb.nl).
     *
     * Mirrors the pattern used by the sibling `github` project: anyone may read,
     * but mutating actions are gated behind a valid session token.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // In tests we never reach out to the network; assume a logged-in user.
        if (app()->environment('testing')) {
            return $next($request);
        }

        // Locally a developer token stands in for a real session.
        if (app()->environment('local')) {
            $authToken = config('app.user_token');
        } else {
            $authToken = $_COOKIE['auth_token']
                ?? $request->query('auth_token')
                ?? $request->bearerToken();
        }

        $ch = curl_init('https://login.ltvb.nl/session/'.$authToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            // A token passed via the query string is promoted to a cookie so
            // subsequent requests stay authenticated, then stripped from the URL.
            if ($request->query('auth_token')) {
                setcookie('auth_token', $authToken, time() + 10 * 24 * 60 * 60, '/', '.lucasvanbriemen.nl', true, true);

                $cleanUrl = $request->url();
                $params = $request->query();
                unset($params['auth_token']);
                if (! empty($params)) {
                    $cleanUrl .= '?'.http_build_query($params);
                }

                return redirect($cleanUrl);
            }

            return $next($request);
        }

        // Browser navigations get redirected to the login service; API/JSON
        // callers get a clean 401 so the frontend can react.
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect('https://login.ltvb.nl?redirect='.urlencode($request->fullUrl()));
    }
}
