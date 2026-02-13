<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\SystemType;
use Illuminate\Http\Request;

class SystemTypesController extends Controller
{
  public function index()
  {

    return view("masterfiles.systemtypes.index");
  }

  public function addSystemType(Request $request)
  {
    // {"systemTypeName":"System Type 1", "systemTypeDescription":"Description 1"}
    $validated = $request->validate([
      "systemTypeName" => "required|string",
      "systemTypeDescription" => "required|string"
    ]);
    SystemType::create([
      "systemType_name" => $validated["systemTypeName"],
      "systemType_description" => $validated["systemTypeDescription"]
    ]);

    return redirect()->back()->with("success", "System Type added successfully");
  }
}
