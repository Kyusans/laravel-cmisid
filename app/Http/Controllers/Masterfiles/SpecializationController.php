<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function addSpecialization(Request $request)
    {
        // {"specName":"Specialization 1"}
        $validated = $request->validate([
            "specName" => "required|string|unique:tblspecializations,spec_name",
        ]);
        Specialization::create([
            "spec_name" => $validated["specName"]
        ]);
        session()->flash("success", "Specialization added successfully");
    }

    public function updateSpecialization(Request $request)
    {
        // {"specId":1, "specName":"Specialization 1"}
        $validated = $request->validate([
            "specName" => "required|string|unique:tblspecializations,spec_name,$request->specId,spec_id",
        ]);
        Specialization::where("spec_id", $request->specId)->update([
            "spec_name" => $validated["specName"]
        ]);
        session()->flash("success", "Specialization updated successfully");
    }
}
