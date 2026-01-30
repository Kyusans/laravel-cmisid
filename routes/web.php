<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, "index"])->name("/");

Route::get("/login", [LoginController::class, "index"])->name("login");
