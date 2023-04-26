<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth()->user()->id;
        $auth = User::where('id', $user)->first();
        $role = $auth->role;

        if ($role == 'admin') {

        } else {
            return response()->json([
                'message' => 'Unauthorized Access'
            ], 403);
        }

        return $next($request);
    }
}
