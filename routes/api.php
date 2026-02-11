<?php

use App\Http\Controllers\Masterfiles\OfficeMasterController;
use App\Http\Controllers\Masterfiles\UserMasterController;
use Illuminate\Support\Facades\Route;


// office masterfile
Route::get("/office-master", [OfficeMasterController::class, "index"])->name("office-master");
Route::post("/add-office", [OfficeMasterController::class, "addOffice"])->name("add-office");
Route::post("/update-office", [OfficeMasterController::class, "updateOffice"])->name("update-office");

// user masterfile
Route::get("/user-master", [UserMasterController::class, "index"])->name("user-master");
Route::post("/add-user", [UserMasterController::class, "addUser"])->name("add-user");
Route::post("/update-user", [UserMasterController::class, "updateUser"])->name("update-user");
