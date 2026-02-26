<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficeMasterController extends Controller
{

  //    @if ($errors->any())
  //         <div class="alert alert-danger">
  //         <ul>
  //             @foreach ($errors->all() as $error)
  //             <li>{{ $error }}</li>
  //             @endforeach
  //         </ul>
  //         </div>
  //     @endif

  public function addOffice(Request $request)
  {
    // {"officeName":"CMISID"}
    try {
      $validated = $request->validate([
        "officeName" => "required|string|unique:tbloffices,office_name",
      ]);
      Office::create([
        "office_name" => $validated["officeName"]
      ]);
      session()->flash("success", "Office added successfully");
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function updateOffice(Request $request)
  {
    // {"officeName":"CITE", "officeId":1}
    try {
      $validated = $request->validate([
        "officeName" => "required|string|unique:tbloffices,office_name,$request->office_id,office_id",
      ]);
      Office::where("office_id", $request->officeId)->update([
        "office_name" => $validated["officeName"]
      ]);
      session()->flash("success", "Office added successfully");
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
}
