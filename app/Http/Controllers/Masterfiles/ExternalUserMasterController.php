<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\ExternalUser;
use Illuminate\Http\Request;

class ExternalUserMasterController extends Controller
{
    public function addExternalUser(Request $request)
    {
        // {"externalName":"External User 1"}
        $validated = $request->validate([
            "externalName" => "required|string|unique:tblexternalusers,external_name",
        ]);

        ExternalUser::create([
            "external_name" => $validated["externalName"]
        ]);
        session()->flash("success", "External User added successfully");
    }

    public function updateExternalUser(Request $request)
    {
        // {"externalId":1, "externalName":"External User 1"}
        $validated = $request->validate([
            "externalName" => "required|string|unique:tblexternalusers,external_name",
        ]);

        ExternalUser::where("external_id", $request->externalId)->update([
            "external_name" => $validated["externalName"]
        ]);
        session()->flash("success", "External User updated successfully");
    }
}
