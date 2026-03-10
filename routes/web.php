<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::livewire("/", "pages::auth.login")->name("login");

Auth::routes();
Route::livewire("/dashboard", "pages::dashboard")->name("dashboard");
Route::livewire("/users", "pages::masterfile.users.user-masterfile")->name("users");
Route::livewire("/masterfiles/roles", "pages::masterfile.role.role-masterfile")->name("roles");

Route::livewire('/information_system/details', 'pages::infosys.show_infosystems')->name('infosystems');

