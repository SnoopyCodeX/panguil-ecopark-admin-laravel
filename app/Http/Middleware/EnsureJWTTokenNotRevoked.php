<?php

namespace App\Http\Middleware;

use App\Models\RevokedToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureJWTTokenNotRevoked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwtToken = JWTAuth::parseToken()->getToken();

        if(RevokedToken::where('token', $jwtToken)->exists())
            return response()->json(['error' => 'Token has been revoked'], 401);

        return $next($request);
    }
}
