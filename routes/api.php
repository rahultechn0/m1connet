<?php

use App\Http\Controllers\LoginController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [LoginController::class, 'login']);
Route::post('/update', [LoginController::class, 'update']);
Route::get('/show', [LoginController::class, 'show']);
Route::post('/sneaker', [LoginController::class, 'sneaker']);
Route::get('/showSneaker', [LoginController::class, 'showSneaker']);

Route::post('/reward', [LoginController::class, 'createReward']);
Route::get('/totalReward', [LoginController::class, 'userTotalReward']);
Route::get('/totalDistance', [LoginController::class, 'userTotalDistance']);
Route::post('/showSneakerId', [LoginController::class, 'showAllSneaker']);
Route::post('/sneakerIdReward', [LoginController::class, 'snIdTotalReward']);
Route::post('/sneakerIdDist', [LoginController::class, 'snIdTotalDist']);


