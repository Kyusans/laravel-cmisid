<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        // {"email":"beasabellach@gmail.com", "password":"beagwapa"}
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ]);
        $user = User::where("user_email", $data["email"])->first();
        return $user && $data["password"] == $user->user_password ? $user : 0;
        // return $user && Hash::check($data["password"], $user->user_password) ? $user : 0;
    }
}
