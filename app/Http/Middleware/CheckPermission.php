<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        // $user = Auth::user();

        $user = User::where('id', Auth::user()->id)->first();

        // Jika user adalah admin, lewati pengecekan hak akses
        if ($user->is_admin) {
            return $next($request);
        }

        // Jika user tidak login atau tidak memiliki salah satu dari permission yang diberikan
        if (!$user->hasAnyPermission($permissions)) {
            return redirect(route('profile.edit'))->with('error', 'Anda tidak memiliki Akses ke halaman tersebut');
        }

        return $next($request);
    }
}