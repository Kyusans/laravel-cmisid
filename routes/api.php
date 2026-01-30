<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post("/user/login", [UserController::class, "login"]);


// Route::middleware('auth:sanctum')->prefix('user')->group(function () {
//     Route::put('/{id}', [UserController::class, 'updateUser']);
//     Route::patch('/{id}/status', [UserController::class, 'setUserStatus']);
//     Route::get('/', [UserController::class, 'getAllUsers']);
// });
