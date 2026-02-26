<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\SystemStatus;
use Illuminate\Http\Request;

class SystemStatusController extends Controller
{
    public function addSystemStatus(Request $request)
    {
        // {"systemStatusName":"System Status 1"}
        try {
            $validated = $request->validate([
                "systemStatusName" => "required|unique:tblsystemstatus,sysStatus_name",
            ]);
            SystemStatus::create([
                "sysStatus_name" => $validated["systemStatusName"]
            ]);
            session()->flash("success", "System Status added successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateSystemStatus(Request $request)
    {
        // {"systemStatusId":1, "systemStatusName":"System Status 1"}
        try {
            $validated = $request->validate([
                "systemStatusName" => "required|unique:tblsystemstatus,sysStatus_name,$request->systemStatusId,sysStatus_id",
            ]);
            SystemStatus::where("sysStatus_id", $request->systemStatusId)->update([
                "sysStatus_name" => $validated["systemStatusName"]
            ]);
            session()->flash("success", "System Status updated successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
