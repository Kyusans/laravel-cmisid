<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\InformationSystem;
use Illuminate\Http\Request;

class InformationSystemController extends Controller
{
    public function addInformationSystem(Request $request)
    {
        try {
            $validated = $request->validate([
                "rank" => "required",
                "isSmartCityInitiative" => "required|boolean",
                "systemName" => "required|string|unique:tblinformationsystems,infoSys_systemName",
                "description" => "required",
                "systemTypeId" => "required",
                "officeId" => "required",
                "systemStatusId" => "required",
                "workEnvId" => "required",
                "devStrategyId" => "required",
                "hasPIA" => "required|boolean",
                "datePia" => "nullable|date",
                "initiationYear" => "required|date_format:Y",
            ]);

            $item = InformationSystem::create([
                "infoSys_rank" => $validated["rank"],
                "infoSys_isSmartCityInitiative" => $validated["isSmartCityInitiative"],
                "infoSys_systemName" => $validated["systemName"],
                "infoSys_description" => $validated["description"],
                "infoSys_systemTypeId" => $validated["systemTypeId"],
                "infoSys_officeId" => $validated["officeId"],
                "infoSys_systemStatusId" => $validated["systemStatusId"],
                "infoSys_workEnvId" => $validated["workEnvId"],
                "infoSys_devStrategyId" => $validated["devStrategyId"],
                "infoSys_hasPIA" => $validated["hasPIA"],
                "infoSys_datePia" => $validated["datePia"],
                "infoSys_initiationYear" => $validated["initiationYear"],
            ]);

            return response()->json(["message" => "Success", "data" => $item], 201);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateInformationSystem(Request $request)
    {
        $validated = $request->validate([
            "rank" => "required",
            "isSmartCityInitiative" => "required",
            "systemName" => "required|unique:tblinformationsystems,infoSys_systemName,$request->infoSys_id,infoSys_id",
            "description" => "required",
            "systemTypeId" => "required",
            "officeId" => "required",
            "systemStatusId" => "required",
            "workEnvId" => "required",
            "devStrategyId" => "required",
            "hasPIA" => "required",
            "datePia" => "required|date",
            "initiationYear" => "required|date_format:Y",
        ]);

        InformationSystem::where("infoSys_id", $request->infoSys_id)->update([
            "infoSys_rank" => $validated["rank"],
            "infoSys_isSmartCityInitiative" => $validated["isSmartCityInitiative"],
            "infoSys_systemName" => $validated["systemName"],
            "infoSys_description" => $validated["description"],
            "infoSys_systemTypeId" => $validated["systemTypeId"],
            "infoSys_officeId" => $validated["officeId"],
            "infoSys_systemStatusId" => $validated["systemStatusId"],
            "infoSys_workEnvId" => $validated["workEnvId"],
            "infoSys_devStrategyId" => $validated["devStrategyId"],
            "infoSys_hasPIA" => $validated["hasPIA"],
            "infoSys_datePia" => $validated["datePia"],
            "infoSys_initiationYear" => $validated["initiationYear"],
        ]);

        session()->flash("success", "Information System updated successfully");
    }
}
