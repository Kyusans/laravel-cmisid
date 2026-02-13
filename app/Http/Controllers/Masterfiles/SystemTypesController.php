<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\SystemType;
use Illuminate\Http\Request;

class SystemTypesController extends Controller
{

  public function addSystemType(Request $request)
  {
    // {"systemTypeName":"System Type 1", "systemTypeDescription":"Description 1"}
    $validated = $request->validate([
      "systemTypeName" => "required|unique:tblsystemtypes,systemType_name",
      "systemTypeDescription" => "required"
    ]);
    SystemType::create([
      "systemType_name" => $validated["systemTypeName"],
      "systemType_description" => $validated["systemTypeDescription"]
    ]);
    session()->flash("success", "System type added successfully");
  }

  public function updateSystemType(Request $request)
  {
    // {"systemTypeId":1, "systemTypeName":"System Type 1", "systemTypeDescription":"Description 1"}
    $validated = $request->validate([
      "systemTypeName" => "required|unique:tblsystemtypes,systemType_name,$request->systemTypeId,systemType_id",
      "systemTypeDescription" => "required"
    ]);

    SystemType::where("systemType_id", $request->systemTypeId)->update([
      "systemType_name" => $validated["systemTypeName"],
      "systemType_description" => $validated["systemTypeDescription"]
    ]);
    session()->flash("success", "System type added successfully");
  }
}
