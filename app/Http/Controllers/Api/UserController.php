<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        $operation = $request->input("operation", "0");
        $json = $request->input("json", "0");

        switch ($operation){
            case "login":
                return $this->login($json);
        }
    }

    protected function login($json){
        return "Hello, gikan ni sa UserController";
    }
}
