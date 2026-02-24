<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{

    public function getAllDevelopers()
    {
        $developers = Developer::with("office", "specialization")->paginate(10);
        return response()->json(["developers" => $developers]);
    }

    public function addDeveloper(Request $request)
    {
        // {"devFirstName":"Bea Ysabel", "devMiddleName": "Macalua", "devLastName": "Lacheca", "devOfficeId": 2,"devSpecId": 1}
        $validated = $request->validate([
            "devFirstName" => "required|string",
            "devMiddleName" => "nullable|string",
            "devLastName" => "required|string",
            "devOfficeId" => "required|integer|exists:tbloffices,office_id",
            "devSpecId" => "required|integer|exists:tblspecializations,spec_id",
        ]);

        $stmt = Developer::create([
            "dev_firstName" => $validated["devFirstName"],
            "dev_middleName" => $validated["devMiddleName"],
            "dev_lastName" => $validated["devLastName"],
            "dev_officeId" => $validated["devOfficeId"],
            "dev_specId" => $validated["devSpecId"],
        ]);

        // return response()->json($stmt);

        session()->flash("success", "Developer added successfully");
    }

    public function updateDeveloper(Request $request)
    {
        // {"devId": 1, "devFirstName": "Bea Ysabel", "devMiddleName": "Macalua", "devLastName": "Macario", "devOfficeId": 2,"devSpecId": 1}
        $validated = $request->validate([
            "devFirstName" => "required|string",
            "devMiddleName" => "nullable|string",
            "devLastName" => "required|string",
            "devOfficeId" => "required|integer|exists:tbloffices,office_id",
            "devSpecId" => "required|integer|exists:tblspecializations,spec_id",
        ]);

        Developer::where("dev_id", $request->devId)->update([
            "dev_firstName" => $validated["devFirstName"],
            "dev_middleName" => $validated["devMiddleName"],
            "dev_lastName" => $validated["devLastName"],
            "dev_officeId" => $validated["devOfficeId"],
            "dev_specId" => $validated["devSpecId"],
        ]);

        session()->flash("success", "Developer updated successfully");
    }
}
