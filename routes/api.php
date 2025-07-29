<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoStreamController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['jwt.auth'])->get('/user', function (Request $request) {
    $userId = $request->get('jwt_user');
    $user = \App\Models\User::find($userId);
    return response()->json(['user' => $user]);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/profile', function (Request $request) {
        $userId = $request->get('jwt_user');
        $user = User::find($userId);
        return response()->json(['user' => $user]);
    });

    Route::post('/videos/upload', [VideoController::class, 'upload']);
    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/{id}/stream', [VideoStreamController::class, 'show']);
    Route::get('/videos/{id}', [VideoController::class, 'show']);
});
