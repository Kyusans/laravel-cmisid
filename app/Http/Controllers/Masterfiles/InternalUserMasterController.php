<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\InternalUser;
use Illuminate\Http\Request;

class InternalUserMasterController extends Controller
{
    public function addInternalUser(Request $request)
    {
        // {"internalName":"Internal User 1"}
        $validated = $request->validate([
            "internalName" => "required|string|unique:tblinternalusers,internal_name",
        ]);
        InternalUser::create([
            "internal_name" => $validated["internalName"]
        ]);
        session()->flash("success", "Internal User added successfully");
    }

    public function updateInternalUser(Request $request)
    {
        // {"internalId":1, "internalName":"Internal User 2"}
        $validated = $request->validate([
            "internalName" => "required|string|unique:tblinternalusers,internal_name",
        ]);
        InternalUser::where("internal_id", $request->internalId)->update([
            "internal_name" => $validated["internalName"]
        ]);
        session()->flash("success", "Internal User updated successfully");
    }
}
