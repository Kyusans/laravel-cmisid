<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\InformationSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformationSystemController extends Controller
{
    public function addInformationSystem(Request $request)
    {
        // {   
        //     "master": {"rank": 1, "isSmartCityInitiative": true, "systemName": "Information System Management System", "description": "Main system for managing all information systems", "systemTypeId": 1, "officeId": 2, "systemStatusId": 1, "workEnvId": 1, "devStrategyId": 1, "hasPIA": false, "datePia": null, "initiationYear": "2024"},
        //     "details":{
        //                  "systemproblems": [{"systemProblemName":"System Problem 1"}, {"systemProblemName":"System Problem 2"}, {"systemProblemName":"System Problem 3"}]
        //                  "developers: [{"devId": 1},{"devId": 2},{"devId": 3}]
        //                  "fundingSources: [{"fundingSourceId": 1}, {"fundingSourceId": 2}, {"fundingSourceId": 3}]
        //               }
        // }
        DB::beginTransaction();
        try {
            $master = $request->master;
            $details = $request->details;

            // return response()->json(["master" => $master, "details" => $details, "systemProblems" => $systemProblems]);

            $validatedMaster = $master->validate([
                "rank" => "required",
                "isSmartCityInitiative" => "required|boolean",
                "mfoConnection" => "required",
                "riseAgendaConnection" => "required",
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

            InformationSystem::create([
                "infoSys_rank" => $validatedMaster["rank"],
                "infoSys_isSmartCityInitiative" => $validatedMaster["isSmartCityInitiative"],

                "infoSys_systemName" => $validatedMaster["systemName"],
                "infoSys_description" => $validatedMaster["description"],
                "infoSys_systemTypeId" => $validatedMaster["systemTypeId"],
                "infoSys_officeId" => $validatedMaster["officeId"],
                "infoSys_systemStatusId" => $validatedMaster["systemStatusId"],
                "infoSys_workEnvId" => $validatedMaster["workEnvId"],
                "infoSys_devStrategyId" => $validatedMaster["devStrategyId"],
                "infoSys_hasPIA" => $validatedMaster["hasPIA"],
                "infoSys_datePia" => $validatedMaster["datePia"],
                "infoSys_initiationYear" => $validatedMaster["initiationYear"],
            ]);
            DB::commit();
            return response()->json(["message" => "Success"], 201);
        } catch (\Exception $e) {
            DB::rollBack();
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
