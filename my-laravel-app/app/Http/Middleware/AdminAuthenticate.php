<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Session::has('admin_id')) {
            Session::put('intended_url', $request->url());
            
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            return redirect()->route('admin.login');
        }

        // Refresh the session
        Session::put('last_activity', time());
        
        $response = $next($request);
        
        // Add cache control headers to all responses
        return $response->header('Cache-Control', 'no-cache, private, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}