<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Subdomain;  // Assuming you have a Subdomain model

class ValidateSubdomain
{
    public function handle(Request $request, Closure $next)
    {
        $subdomain = $request->route('subdomain');  // Get the subdomain parameter

        // Check if the subdomain exists in the database
        if (!Subdomain::where('name', $subdomain)->exists()) {
            abort(404, 'Subdomain not found.');
        }

        return $next($request);
    }
}
