<?php

use App\Http\Controllers\Api\LinksController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/api/register', [UsersController::class, 'store']);
Route::post('/api/login', [UsersController::class, 'login']);

Route::get('/{teste}', [LinksController::class, 'testando']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('api/links')->group(function () {
        Route::get('/', [LinksController::class, 'index']);
        Route::post('/', [LinksController::class, 'store']);
    });
});

// Route::get('/users', [UsersController::class, 'show']);
// Route::get('/teste', function () {
//     $numeroAleatorio = rand(6, 8);
//     $stringAleatoria = mt_rand();
//     $hash = md5($stringAleatoria);
//     $linkAleatorio = substr($hash, 0, $numeroAleatorio);

//     return $linkAleatorio;
//     // return auth()->user();
// });
