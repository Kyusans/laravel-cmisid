<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $operation = $request->input("operation", "0");
        $json = $request->input("json", "0");

        return match ($operation) {
            "signup" => $this->signup($json),
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
            return -1;
        }

        $stmt = User::create([
            "user_firstName" => $data["firstName"],
            "user_middleName" => $data["middleName"] ?? null,
            "user_lastName" => $data["lastName"],
            "user_email" => $data["email"],
            "user_password" => $data["password"],
            "user_birthdate" =>$data["birthdate"],
            "user_role" => $data["userRole"]
        ]);
        return $stmt ? 1 : 0;
    }
}
