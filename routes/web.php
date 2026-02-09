<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, "index"])->name("/");
Route::post("/user/login", [AuthController::class, "login"])->name("user.login");

Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");
