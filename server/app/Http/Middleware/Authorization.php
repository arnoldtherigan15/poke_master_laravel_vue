<?php

namespace App\Http\Middleware;

use App\Models\Pokemon;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user_id = Auth::user()->id;
            $pokemons_user_id = Pokemon::findOrFail($request->route('id'))->user_id;
            if(!($user_id == $pokemons_user_id)) {
                return response()->json(['error' => 'Youre not authorize to do this'], 403);
            }
            return $next($request);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pokemon with id:' . $request->route('id') . ' not found'], 404);
        }
    }
}
