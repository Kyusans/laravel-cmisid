<?php

use App\Http\Controllers\Transaction\InformationSystemController;
use Illuminate\Support\Facades\Route;


// -- transactions

// information system transaction
Route::post("/add-information-system", [InformationSystemController::class, "addInformationSystem"])->name("add-information-system");
Route::post("/update-information-system", [InformationSystemController::class, "updateInformationSystem"])->name("update-information-system");
