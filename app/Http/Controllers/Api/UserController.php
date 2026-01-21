<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $operation = $request->input("operation", "0");
        $json = $request->input("json", "0");

        return match ($operation) {
            "signup" => $this->signup($json),
            "login" => $this->login($json),
            "update" => $this->updateUser($json),
            "setUserStatus" => $this->setUserStatus($json),
            "getAllUsers" => $this->getAllUsers($json),
            default => "Invalid Operation"
        };
    }

    protected function signup($json)
    {
        // {"firstName":"Bea", "middleName":"Macalua", "lastName":"lacheca", "email":"beasabellach@gmail.com", "birthdate":"2004-01-01", "password":"beagwapa", "userRole": 1}
        $data = json_decode($json, true);

        $validator = Validator::make($data, [
            "email" => "required|email|unique:tblusers,user_email"
        ]);
        if ($validator->fails()) {
            return -1; // email exist 
        }

        $stmt = User::create([
            "user_firstName" => $data["firstName"],
            "user_middleName" => $data["middleName"] ?? null,
            "user_lastName" => $data["lastName"],
            "user_email" => $data["email"],
            "user_password" => $data["password"],
            "user_birthdate" => $data["birthdate"],
            "user_role" => $data["userRole"]
        ]);
        return $stmt ? 1 : 0;
    }

    protected function login($json)
    {
        // {"email":"beasabellach@gmail.com", "password":"beagwapa"}
        $data = json_decode($json, true);
        $user = User::where("user_email", $data["email"])->first();
        return $user && Hash::check($data["password"], $user->user_password) ? $user : 0;
    }

    protected function updateUser($json)
    {
        // {"userId": 1, "firstName":"Beas", "middleName":"Macalua", "lastName":"lacheca", "email":"beasabellach@gmail.com", "birthdate":"2004-01-01", "password":"beagwapa", "userRole": 1}
        $data = json_decode($json, true);
        $userId = $data["userId"];
        $user = User::find($userId ?? 0);
        if (!$user) {
            return 0; // walay user
        }

        // $validator = Validator::make($data, [
        //     "email" => "required|email|unique:tblusers,user_email," . $userId . ",user_id"
        // ]);
        // if ($validator->fails()) {
        //     return -1; // email exist 
        // }

        $stmt = User::where("user_id", $userId)
            ->update([
                "user_firstName" => $data["firstName"] ?? $user->user_firstName,
                "user_middleName" => $data["middleName"] ?? $user->user_middleName,
                "user_lastName" => $data["lastName"] ?? $user->user_lastName,
                "user_birthdate" => $data["birthdate"] ?? $user->user_birthdate,
                "user_role" => $data["userRole"] ?? $user->user_role
            ]);

        return $stmt ? 1 : 0;
    }

    protected function setUserStatus($json)
    {
        // {"userId": 2, "operator": "active"}
        $data = json_decode($json, true);
        $stmt = User::where("user_id", $data["userId"])
            ->update([
                "user_status" => $data["operator"]
            ]);
        return $stmt ? 1 : 0;
    }

    protected function getAllUsers($json)
    {
        // {"operator": "active"}
        $data = json_decode($json, true);
        $stmt = User::where("user_status", $data["operator"])
            ->orderByDesc("user_id")->get();
        return $stmt;
    }
}
