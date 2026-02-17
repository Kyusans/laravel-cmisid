<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Masterfiles\OfficeMasterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, "index"])->name("/");
Route::post("/user/login", [AuthController::class, "login"])->name("user.login");

Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [App\Http\Controllers\Tables\UsersController::class,'index'])->name('users');
Route::get('/information_systems', [App\Http\Controllers\Tables\InfoSystemController::class,'index'])->name('infosystems');

// Edit these into a variable for specific users 
Route::get('/user/details', [App\Http\Controllers\Details\UserController::class,'index']);
Route::get('/user/edit', [App\Http\Controllers\Edit\UserController::class,'index']);

// Edit these into a variable for specific information system
Route::get('/information_system/details', [App\Http\Controllers\Details\InfoSystemController::class,'index']);
Route::get('/information_system/edit', [App\Http\Controllers\Edit\InfoSystemController::class,'index']);

// User Creation and Login
Route::get('/create/user', [App\Http\Controllers\Tables\UsersController::class, 'create'])->name('create.user');
Route::post('/create/user', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'addUser'])->name('store.user');