<?php

namespace App\Http\Controllers\Tables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $table_data = [
            "columns" => [
                "Rank",
                "Name",
                "Type",
                "Office",
                "Initiation Year",
                "PIA Status",
            ],
            "rows" => [
                [
                    1,
                    "Otto",
                    "Type 1",
                    "Office Name",
                    "2025",
                    "IN PROGRESS",
                ],
            ],
        ];

        return view('tables.infosystems', ['table_data' => $table_data]);
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
