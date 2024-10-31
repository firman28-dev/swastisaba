<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AutoLogout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $lastActivity = Session::get('lastActivity');

            if ($lastActivity) {
                // $inactiveDuration = Carbon::now()->diffInHours($lastActivity);
                $inactiveDuration = Carbon::now()->diffInMinutes($lastActivity);
                
                if ($inactiveDuration >= 120) { // Ubah menjadi 1 menit
                    // Clear session and logout
                    $user->session = null; // Remove token
                    $user->save(); // Save changes
                    Session::flush();
                    Auth::logout();
                    return redirect('login')->with('message', 'You have been logged out due to inactivity.');
                }
            }

            // Update last activity time
            Session::put('lastActivity', Carbon::now());
        }

        return $next($request);
    }

}