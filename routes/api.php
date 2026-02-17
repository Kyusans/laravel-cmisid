<?php

use App\Http\Controllers\Masterfiles\DeveloperController;
use App\Http\Controllers\Masterfiles\FundingSourceController;
use App\Http\Controllers\Masterfiles\OfficeMasterController;
use App\Http\Controllers\Masterfiles\RiseAgendaController;
use App\Http\Controllers\Masterfiles\SpecializationController;
use App\Http\Controllers\Masterfiles\SystemStatusController;
use App\Http\Controllers\Masterfiles\SystemTypesController;
use App\Http\Controllers\Masterfiles\UserMasterController;
use App\Http\Controllers\Masterfiles\WorkingEnvironmentController;
use Illuminate\Support\Facades\Route;


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
