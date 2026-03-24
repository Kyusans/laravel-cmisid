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
  Route::livewire("/masterfiles/working-environment", "pages::masterfile.working-environment.working-environment-masterfile")->name("workingEnvironment");
  Route::livewire("/masterfiles/system-status", "pages::masterfile.system-status.system-status-masterfile")->name("systemStatus");
  Route::livewire("/masterfiles/rise-agenda-type", "pages::masterfile.rise-agenda-type.rise-agenda-type-masterfile")->name("riseAgendaType");
  Route::livewire("/masterfiles/rise-agenda", "pages::masterfile.rise-agenda.rise-agenda-masterfile")->name("riseAgenda");
  Route::livewire("/masterfiles/developer", "pages::masterfile.developer.developer-masterfile")->name("developer");
  Route::livewire("/masterfiles/development-strategy", "pages::masterfile.development-strategy.development-strategy-masterfile")->name("developmentStrategy");
  Route::livewire("/masterfiles/funding-source", "pages::masterfile.funding-source.funding-source-masterfile")->name("fundingSource");
  Route::livewire("/masterfiles/mfo", "pages::masterfile.mfo.mfo-masterfile")->name("mfo");
  Route::livewire("/masterfiles/ppa", "pages::masterfile.ppa.ppa-masterfiles")->name("ppa");
  Route::livewire('/information-systems', 'pages::transaction.information-system.information-system-page')->name('infosystems');
  Route::livewire("/change-password", "pages::account.change-password")->name("change-password");
  });
