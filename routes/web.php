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


// Users (Revising)
Route::livewire('/users','pages::users.show_users')->name('users');
Route::get('/create/user', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'create'])->name('create.user');
Route::post('/create/user', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'addUser'])->name('store.user');
Route::get('/user/details/{user}', [App\Http\Controllers\Masterfiles\UserMasterController::class,'details'])->name('details.user');
Route::get('/user/edit/{user}', [App\Http\Controllers\Masterfiles\UserMasterController::class,'edit'])->name('edit.user');
Route::put('/user/details/{user}', [App\Http\Controllers\Masterfiles\UserMasterController::class,'updateUser'])->name('update.user');

// Information System (Revising)
//Route::get('/information_system/details', [App\Http\Controllers\Details\InfoSystemController::class,'index']);
//Route::get('/information_system/edit', [App\Http\Controllers\Edit\InfoSystemController::class,'index']);
Route::get('/information_systems', [App\Http\Controllers\Masterfiles\InformationSystemsMasterController::class,'index'])->name('infosystems');