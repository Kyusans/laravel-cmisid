<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Mfo;
use Illuminate\Http\Request;

class MfoMasterController extends Controller
{
    public function addMfo(Request $request)
    {
        // {"mfoName":"MFO 1", "officeId":1}
        try {
            $validated = $request->validate([
                "mfoName" => "required|string",
                "officeId" => "required|integer",
            ]);
            Mfo::create([
                "mfo_name" => $validated["mfoName"],
                "mfo_officeId" => $validated["officeId"]
            ]);
            session()->flash("success", "MFO added successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateMfo(Request $request)
    {
        // {"mfoId":1, "mfoName":"MFO 2", "officeId":2}
        try {
            $validated = $request->validate([
                "mfoName" => "required|string",
                "officeId" => "required|integer",
            ]);
            Mfo::where("mfo_id", $request->mfoId)->update([
                "mfo_name" => $validated["mfoName"],
                "mfo_officeId" => $validated["officeId"]
            ]);
            // return response()->json($stmt);
            session()->flash("success", "MFO updated successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
