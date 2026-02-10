<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Masterfiles\OfficeMasterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, "index"])->name("/");
Route::post("/user/login", [AuthController::class, "login"])->name("user.login");

Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [App\Http\Controllers\Tables\UsersController::class,'index'])->name('users');
