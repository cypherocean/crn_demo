<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Extract the subdomain from the host
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        // Optionally, exclude the main domain (e.g., crndemo.local)
        if ($subdomain === 'crndemo') {
            $subdomain = null;
        }

        // Attach the subdomain to the request for further use
        $request->merge(['subdomain' => $subdomain]);

        return $next($request);
    }
}
