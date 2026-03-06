<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Masterfiles\UserMasterController;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', [AuthController::class, "index"])->name("/");
Route::livewire("/", "pages::auth.login")->name("login");

Auth::routes();
Route::livewire("/dashboard", "pages::dashboard")->name("dashboard");
Route::livewire("/users", "pages::masterfile.users.user-masterfile")->name("users");
Auth::routes();

// Route::livewire("/masterfiles", "pages::masterfiles.masterfile_main")->name("masterfiles");

// Users (Revising)
Route::get('/create/user', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'create'])->name('create.user');
Route::post('/create/user', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'addUser'])->name('store.user');
Route::get('/details/user/{user}', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'details'])->name('details.user');
Route::get('/edit/user/{user}', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'edit'])->name('edit.user');
Route::put('/update/user/{user}', [App\Http\Controllers\Masterfiles\UserMasterController::class, 'updateUser'])->name('update.user');

// Information System (Revising)
//Route::get('/information_system/edit', [App\Http\Controllers\Edit\InfoSystemController::class,'index']);
Route::livewire('/information_system/details', 'pages::infosys.show_infosystems')->name('infosystems');
//Route::get('/information_system/details', [App\Http\Controllers\Details\InfoSystemController::class,'index']);
//Route::get('/information_systems', [App\Http\Controllers\Masterfiles\InformationSystemsMasterController::class,'index'])->name('infosystems');
