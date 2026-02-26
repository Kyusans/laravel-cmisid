<?php

namespace App\Http\Controllers\MasterFiles;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleMasterController extends Controller
{
    public function addRole(Request $request)
    {
        // {"roleName":"Role 1"}
        try {
            $validated = $request->validate([
                "roleName" => "required|string|unique:tblroles,role_name",
            ]);
            Role::create([
                "role_name" => $validated["roleName"]
            ]);
            // return response()->json(["message" => "Role added successfully"]);
            session()->flash("success", "Role added successfully");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateRole(Request $request)
    {
        try {
            // {"roleId":1, "roleName":"Role 2"}
            $validated = $request->validate([
                "roleName" => "required|string|unique:tblroles,role_name,$request->roleId,role_id",
            ]);
            Role::where("role_id", $request->roleId)->update([
                "role_name" => $validated["roleName"]
            ]);
            // return response()->json(["message" => "Role updated successfully"]);
            session()->flash("success", "Role updated successfully");
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
