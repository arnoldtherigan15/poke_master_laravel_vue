<?php

use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'api'], function () {
    Route::post('register', [UserController::class,'register']);
    Route::post('login', [UserController::class,'login']);
    Route::post('logout', [UserController::class,'logout']);
    Route::get('me', [UserController::class,'me']);
    Route::post('logout', [UserController::class,'logout']);
});

Route::resource('pokemons', PokemonController::class)->except(['create', 'edit', 'show', 'update', 'destroy']);
Route::get('pokemons/{id}', [PokemonController::class,'show'])->middleware('authorization');
Route::delete('pokemons/{id}', [PokemonController::class,'destroy'])->middleware('authorization');
Route::put('pokemons/{id}', [PokemonController::class,'update'])->middleware('authorization');