<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    // Define your API key
    private $apiKey = 'BA673A414C3B44C98478BB5CF10A0F832574090C';

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {

        $headerKey = $request->bearerToken();
        if (!$headerKey || $headerKey !== $this->apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or missing API key'
            ], 401);
        }

        return $next($request);
    }
}
