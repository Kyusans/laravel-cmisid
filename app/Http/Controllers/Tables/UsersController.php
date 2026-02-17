<?php

namespace App\Http\Controllers\Tables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Office;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sample table data. Replace it with table_data
        $table_data = [
            "columns" => [
                "Firstname",
                "Lastname",
                "Role",
            ],
            "rows" => [
                [
                    "Mark",
                    "Otto",
                    "Office User",
                ],
                [
                    "Jacob",
                    "Thornton",
                    "Office User",
                ],
                [
                    "John",
                    "Doe",
                    "System Admin",
                ],
            ],
        ];

        return view('tables.users', ['table_data' => $table_data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $offices = Office::all();
        return view("tables.create_user", compact("roles","offices"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
