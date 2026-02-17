<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Mfo;
use Illuminate\Http\Request;

class MfoMasterController extends Controller
{
    public function addMfo(Request $request)
    {
        // {"mfoName":"MFO 1"}
        $validated = $request->validate([
            "mfoName" => "required|string|unique:tblmfo,mfo_name",
        ]);
        Mfo::create([
            "mfo_name" => $validated["mfoName"]
        ]);
        session()->flash("success", "MFO added successfully");
    }

    public function updateMfo(Request $request)
    {
        // {"mfoId":1, "mfoName":"MFO 2"}
        $validated = $request->validate([
            "mfoName" => "required|string|unique:tblmfo,mfo_name,$request->mfoId,mfo_id",
        ]);
        Mfo::where("mfo_id", $request->mfoId)->update([
            "mfo_name" => $validated["mfoName"]
        ]);
        // return response()->json($stmt);
        session()->flash("success", "MFO updated successfully");
    }
}
