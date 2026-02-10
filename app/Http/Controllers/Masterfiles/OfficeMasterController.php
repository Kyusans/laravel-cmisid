<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeMasterController extends Controller
{
    public function addOffice(Request $request)
    {
        // {"officeName":"CMISID"}
        $validated = $request->validate([
            "office_name" => "required|string|unique:tbloffices,office_name",
        ]);
        $stmt = Office::create([
            "office_name" => $validated["office_name"]
        ]);
        $status = $stmt ? "success" : "failed";
        $message = $stmt ? "Office successfully added" : "Failed to add office";
        return response()->json([
            "status" => $status,
            "message" => $message
        ]);
    }
}
