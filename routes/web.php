<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::livewire("/", "pages::auth.login")->name("login");

Auth::routes();
Route::middleware("auth")->group(function () {
  Route::livewire("/dashboard", "pages::dashboard")->name("dashboard");
  Route::livewire("/masterfiles/users", "pages::masterfile.users.user-masterfile")->name("users");
  Route::livewire("/masterfiles/roles", "pages::masterfile.role.role-masterfile")->name("roles");
  Route::livewire("/masterfiles/office", "pages::masterfile.office.office-masterfile")->name("offices");
  Route::livewire("/masterfiles/system-type", "pages::masterfile.system-type.system-type-masterfile")->name("systemTypes");

  Route::livewire('/information_system/details', 'pages::infosys.show_infosystems')->name('infosystems');
});
