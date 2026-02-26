<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\FundingSource;
use Illuminate\Http\Request;

class FundingSourceController extends Controller
{
    public function addFundingSource(Request $request)
    {
        // {"fundingName":"Funding Source 1"}
        try {
            $validated = $request->validate([
                "fundingName" => "required|string|unique:tblfundingsource,funding_name",
            ]);
            FundingSource::create([
                "funding_name" => $validated["fundingName"]
            ]);
            session()->flash("success", "Funding Source added successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateFundingSource(Request $request)
    {
        // {"fundingId":1, "fundingName":"Funding Source 1"}
        try {
            $validated = $request->validate([
                "fundingName" => "required|string|unique:tblfundingsource,funding_name,$request->fundingId,funding_id",
            ]);
            FundingSource::where("funding_id", $request->fundingId)->update([
                "funding_name" => $validated["fundingName"]
            ]);
            session()->flash("success", "Funding Source updated successfully");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
