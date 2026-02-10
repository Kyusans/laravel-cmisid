<?php

use App\Http\Controllers\Masterfiles\OfficeMasterController;
use Illuminate\Support\Facades\Route;

// office masterfile
Route::post("/add-office", [OfficeMasterController::class, "addOffice"])->name("add-office");
