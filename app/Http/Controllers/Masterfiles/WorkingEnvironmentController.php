<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\WorkingEnvironment;
use Illuminate\Http\Request;

class WorkingEnvironmentController extends Controller
{
    public function addWorkingEnvironment(Request $request)
    {
        // {"workEnvName":"Work Environment 1", "workEnvDescription":"Description 1"}
        $validated = $request->validate([
            "workEnvName" => "required|unique:tblworkingenvironments,workEnv_name",
            "workEnvDescription" => "required"
        ]);

        WorkingEnvironment::create([
            "workEnv_name" => $validated["workEnvName"],
            "workEnv_description" => $validated["workEnvDescription"]
        ]);

        session()->flash("success", "Work Environment added successfully");
    }

    public function updateWorkingEnvironment(Request $request)
    {
        // {"workEnvId":1, "workEnvName":"Work Environment 1", "workEnvDescription":"Description 1"}
        $validated = $request->validate([
            "workEnvName" => "required|unique:tblworkingenvironments,workEnv_name,$request->workEnvId,workEnv_id",
            "workEnvDescription" => "required"
        ]);

        WorkingEnvironment::where("workEnv_id", $request->workEnvId)->update([
            "workEnv_name" => $validated["workEnvName"],
            "workEnv_description" => $validated["workEnvDescription"]
        ]);
        session()->flash("success", "Work Environment updated successfully");
    }
}
