<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\RiseAgenda;
use Illuminate\Http\Request;

class RiseAgendaController extends Controller
{
    public function addRiseAgenda(Request $request)
    {
        // {"riseAgendaName":"Rise Agenda 1"}
        try {
            $validated = $request->validate([
                "riseAgendaName" => "required|unique:tblriseagendas,riseAgenda_name",
            ]);

            RiseAgenda::create([
                "riseAgenda_name" => $validated["riseAgendaName"]
            ]);

            session()->flash("success", "Rise Agenda added successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }

    public function updateRiseAgenda(Request $request)
    {
        // {"riseAgendaId":1, "riseAgendaName":"Rise Agenda 1"}
        try {
            $validated = $request->validate([
                "riseAgendaName" => "required|unique:tblriseagendas,riseAgenda_name,$request->riseAgendaId,riseAgenda_id",
            ]);

            RiseAgenda::where("riseAgenda_id", $request->riseAgendaId)->update([
                "riseAgenda_name" => $validated["riseAgendaName"]
            ]);

            session()->flash("success", "Rise Agenda updated successfully");
        } catch (\Exception $th) {
            return $th->getMessage();
        }
    }
}
