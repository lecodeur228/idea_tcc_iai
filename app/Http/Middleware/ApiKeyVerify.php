<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd('test');
        $providerKey = $request->header('X-API-KEY');
        if(!$providerKey ||  $providerKey !== env('API_KEY')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
