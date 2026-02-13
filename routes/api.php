<?php

use App\Http\Controllers\Masterfiles\OfficeMasterController;
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
