<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ValidationCriticFilm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::id() != $request->user_id) {
            return response()->json(['message' => 'Vous ne pouvez pas ajouter une critique pour un autre utilisateur'], 403);
        }

        $alreadyExists = DB::table('critics')
                    ->where('user_id', $request->user_id)
                    ->where('film_id', $request->film_id)
                    ->get()
                    ->isNotEmpty();

        if ($alreadyExists) {
            return response()->json(['message' => 'Vous ne pouvez pas ajouter plus d\'une critique pour le même film'], 403);
        }

        return $next($request);
    }
}
