<?php
    
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Application\Enums\UserRole;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // First, check if we have a valid session
        if (!Session::has('admin_id') || !Auth::check() || Auth::id() !== Session::get('admin_id')) {
            // Clear everything if session is invalid
            Auth::logout();
            Session::flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('admin.login')
                ->with('error', 'Please login to continue');
        }

        // Check session timeout
        $lastActivity = Session::get('last_activity');
        if ($lastActivity && time() - $lastActivity > config('session.lifetime') * 60) {
            Auth::logout();
            Session::flush();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('admin.login')
                ->with('error', 'Session expired');
        }

        Session::put('last_activity', time());
        
        $response = $next($request);
        
        return $response
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
    }
}
