<?php

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


Route::get('/getfilm', [\App\Http\Controllers\FilmController::class, 'getFilm']);
Route::get('/searchFilm', [\App\Http\Controllers\FilmController::class, 'searchfilm']);
Route::post('/login', [\App\Http\Controllers\FilmController::class, 'login']);
//Api يحتاج Auth
Route::group(['middleware'=>'auth:api'],function() {
Route::post('/updateFilm/{id}', [\App\Http\Controllers\FilmController::class, 'update']);
Route::delete('/deleteFilm/{id}', [\App\Http\Controllers\FilmController::class, 'delete']);
Route::delete('/deleteCatigory/{id}', [\App\Http\Controllers\CatigoryFilmController::class, 'delete']);
Route::post('/newfilm', [\App\Http\Controllers\FilmController::class, 'store']);
Route::post('/updateCatigory/{id}', [\App\Http\Controllers\CatigoryFilmController::class, 'update']);
Route::post('/newcatigory', [\App\Http\Controllers\CatigoryFilmController::class, 'store']);
Route::get('/getcatigory', [\App\Http\Controllers\CatigoryFilmController::class, 'getCategory']);
});
