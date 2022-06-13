<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('films', 'App\Http\Controllers\FilmController@index');
Route::get('films/{id}', 'App\Http\Controllers\FilmController@show');
Route::get('films/{id}/actors', 'App\Http\Controllers\FilmController@showActors');
Route::middleware(['auth:sanctum', 'admin'])->post('films', 'App\Http\Controllers\FilmController@store');
Route::middleware(['auth:sanctum', 'admin'])->delete('films/{id}', 'App\Http\Controllers\FilmController@destroy');

Route::middleware(['auth:sanctum', 'critic_film'])->post('critics', 'App\Http\Controllers\CriticController@store');

Route::middleware('auth:sanctum')->get('users', 'App\Http\Controllers\UserController@show');
Route::post('users', 'App\Http\Controllers\UserController@register');
Route::post('users/login', 'App\Http\Controllers\UserController@login');
Route::post('users/logout', 'App\Http\Controllers\UserController@logout');
Route::middleware('auth:sanctum')->put('users', 'App\Http\Controllers\UserController@update');
Route::middleware('auth:sanctum')->put('users/password', 'App\Http\Controllers\UserController@updatePassword');
