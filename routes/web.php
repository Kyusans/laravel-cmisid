<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Masterfiles\DeveloperController;
use App\Http\Controllers\Masterfiles\DevelopmentStrategyMasterController;
use App\Http\Controllers\Masterfiles\ExternalUserMasterController;
use App\Http\Controllers\Masterfiles\FundingSourceController;
use App\Http\Controllers\Masterfiles\InternalUserMasterController;
use App\Http\Controllers\Masterfiles\MfoMasterController;
use App\Http\Controllers\Masterfiles\OfficeMasterController;
use App\Http\Controllers\Masterfiles\PpaMasterController;
use App\Http\Controllers\Masterfiles\RiseAgendaController;
use App\Http\Controllers\Masterfiles\SpecializationController;
use App\Http\Controllers\Masterfiles\SystemStatusController;
use App\Http\Controllers\Masterfiles\SystemTypesController;
use App\Http\Controllers\Masterfiles\UserMasterController;
use App\Http\Controllers\Masterfiles\WorkingEnvironmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, "index"])->name("/");
Route::post("/user/login", [AuthController::class, "login"])->name("user.login");

Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [App\Http\Controllers\Tables\UsersController::class, 'index'])->name('users');
Route::get('/information_systems', [App\Http\Controllers\Tables\InfoSystemController::class, 'index'])->name('infosystems');

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

// -- masterfiles

// office masterfile
Route::get("/office-master", [OfficeMasterController::class, "index"])->name("office-master");
Route::post("/add-office", [OfficeMasterController::class, "addOffice"])->name("add-office");
Route::post("/update-office", [OfficeMasterController::class, "updateOffice"])->name("update-office");

// user masterfile
Route::get("/user-master", [UserMasterController::class, "index"])->name("user-master");
Route::post("/add-user", [UserMasterController::class, "addUser"])->name("add-user");
Route::post("/update-user", [UserMasterController::class, "updateUser"])->name("update-user");

// system types masterfile
Route::post("/add-system-types", [SystemTypesController::class, "addSystemType"])->name("add-system-types");
Route::post("/update-system-types", [SystemTypesController::class, "updateSystemType"])->name("update-system-types");

// working environment masterfile
Route::post("/add-working-environment", [WorkingEnvironmentController::class, "addWorkingEnvironment"])->name("add-working-environment");
Route::post("/update-working-environment", [WorkingEnvironmentController::class, "updateWorkingEnvironment"])->name("update-working-environment");

// system status masterfile
Route::post("/add-system-status", [SystemStatusController::class, "addSystemStatus"])->name("add-system-status");
Route::post("/update-system-status", [SystemStatusController::class, "updateSystemStatus"])->name("update-system-status");

// rise agenda masterfile
Route::post("/add-rise-agenda", [RiseAgendaController::class, "addRiseAgenda"])->name("add-rise-agenda");
Route::post("/update-rise-agenda", [RiseAgendaController::class, "updateRiseAgenda"])->name("update-rise-agenda");

// specialization masterfile
Route::post("/add-specialization", [SpecializationController::class, "addSpecialization"])->name("add-specialization");
Route::post("/update-specialization", [SpecializationController::class, "updateSpecialization"])->name("update-specialization");

// developer masterfile
Route::post("/add-developer", [DeveloperController::class, "addDeveloper"])->name("add-developer");
Route::post("/update-developer", [DeveloperController::class, "updateDeveloper"])->name("update-developer");

// funding source masterfile
Route::post("/add-funding-source", [FundingSourceController::class, "addFundingSource"])->name("add-funding-source");
Route::post("/update-funding-source", [FundingSourceController::class, "updateFundingSource"])->name("update-funding-source");

// internal user masterfile
Route::post("/add-internal-user", [InternalUserMasterController::class, "addInternalUser"])->name("add-internal-user");
Route::post("/update-internal-user", [InternalUserMasterController::class, "updateInternalUser"])->name("update-internal-user");

// external user masterfile
Route::post("/add-external-user", [ExternalUserMasterController::class, "addExternalUser"])->name("add-external-user");
Route::post("/update-external-user", [ExternalUserMasterController::class, "updateExternalUser"])->name("update-external-user");

// mfo masterfile
Route::post("/add-mfo", [MfoMasterController::class, "addMfo"])->name("add-mfo");
Route::post("/update-mfo", [MfoMasterController::class, "updateMfo"])->name("update-mfo");

// ppa masterfile
Route::post("/add-ppa", [PpaMasterController::class, "addPpa"])->name("add-ppa");
Route::post("/update-ppa", [PpaMasterController::class, "updatePpa"])->name("update-ppa");

// development strategy masterfile
Route::post("/add-development-strategy", [DevelopmentStrategyMasterController::class, "addDevelopmentStrategy"])->name("add-development-strategy");
Route::post("/update-development-strategy", [DevelopmentStrategyMasterController::class, "updateDevelopmentStrategy"])->name("update-development-strategy");
