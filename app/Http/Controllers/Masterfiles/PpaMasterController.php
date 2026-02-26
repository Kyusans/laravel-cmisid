<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Ppa;
use Illuminate\Http\Request;

class PpaMasterController extends Controller
{
    public function addPpa(Request $request)
    {
        // {"ppaName":"PPA 1", "officeId":1}
        try {
            $validated = $request->validate([
                "ppaName" => "required|string",
                "officeId" => "required|integer",
            ]);
            Ppa::create([
                "ppa_name" => $validated["ppaName"],
                "ppa_officeId" => $validated["officeId"]
            ]);
            session()->flash("success", "PPA added successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updatePpa(Request $request)
    {
        // {"ppaId":1,"ppaName":"PPA 2", "officeId":1}
        try {
            $validated = $request->validate([
                "ppaName" => "required|string",
                "officeId" => "required|integer",
            ]);
            Ppa::where("ppa_id", $request->ppaId)->update([
                "ppa_name" => $validated["ppaName"],
                "ppa_officeId" => $validated["officeId"]
            ]);
            // return response()->json($stmt);
            session()->flash("success", "PPA updated successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
