<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('API_KEY') !== 'helloatg') {
            return response()->json(['status' => 0, 'message' => 'Invalid API key'], 401);
        }

        return $next($request);
    }
}
