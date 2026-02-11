<?php

namespace App\Http\Controllers\Tables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                "Email",
                "Role",
                "Office",
            ],
            "rows" => [
                [
                    "Mark",
                    "Otto",
                    "markotto@mdo.com",
                    "Office User",
                    "Office 1",
                ],
                [
                    "Jacob",
                    "Thornton",
                    "jacobthornton@jt.com",
                    "Office User",
                    "Office 2",
                ],
                [
                    "John",
                    "Doe",
                    "johndoe@social.com",
                    "System Admin",
                    "None",
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
        //
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
