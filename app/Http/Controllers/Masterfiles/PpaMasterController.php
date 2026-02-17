<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Ppa;
use Illuminate\Http\Request;

class PpaMasterController extends Controller
{
    public function addPpa(Request $request)
    {
        // {"ppaName":"PPA 1"}
        $validated = $request->validate([
            "ppaName" => "required|string|unique:tblppa,ppa_name",
        ]);
        Ppa::create([
            "ppa_name" => $validated["ppaName"]
        ]);
        session()->flash("success", "PPA added successfully");
    }

    public function updatePpa(Request $request)
    {
        // {"ppaId":1,"ppaName":"PPA 2"}
        $validated = $request->validate([
            "ppaName" => "required|string|unique:tblppa,ppa_name,$request->ppaId,ppa_id",
        ]);
        Ppa::where("ppa_id", $request->ppaId)->update([
            "ppa_name" => $validated["ppaName"]
        ]);
        // return response()->json($stmt);
        session()->flash("success", "PPA updated successfully");
    }
}
