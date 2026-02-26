<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentStrategy;
use Illuminate\Http\Request;

class DevelopmentStrategyMasterController extends Controller
{
    public function addDevelopmentStrategy(Request $request)
    {
        // {"developmentStrategyName":"Development Strategy 1"}
        try {
            $validate = $request->validate([
                "developmentStrategyName" => "required|string|unique:tbldevelopmentstrategies,devStrategy_name"
            ]);
            DevelopmentStrategy::create([
                "devStrategy_name" => $validate["developmentStrategyName"]
            ]);
            session()->flash("success", "Development Strategy added successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateDevelopmentStrategy(Request $request)
    {
        // {"devStrategyId":1,"developmentStrategyName":"Development Strategy 2"}
        try {
            $validate = $request->validate([
                "developmentStrategyName" => "required|string|unique:tbldevelopmentstrategies,devStrategy_name,$request->devStrategyId,devStrategy_id"
            ]);
            DevelopmentStrategy::where("devStrategy_id", $request->devStrategyId)->update([
                "devStrategy_name" => $validate["developmentStrategyName"]
            ]);
            session()->flash("success", "Development Strategy updated successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
