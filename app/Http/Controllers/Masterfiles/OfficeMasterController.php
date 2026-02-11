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

  public function index()
  {
    $offices = Office::all();
    return view("masterfiles.office.index", compact("offices"));
  }

  public function addOffice(Request $request)
  {
    // {"officeName":"CMISID"}
    $validated = $request->validate([
      "officeName" => "required|string|unique:tbloffices,office_name",
    ]);
    $stmt = Office::create([
      "office_name" => $validated["officeName"]
    ]);
    return redirect()->back()->with("success", "Office added successfully");
  }

  public function updateOffice(Request $request)
  {
    // {"officeName":"CITE", "officeId":1}
    $validated = $request->validate([
      "officeName" => "required|string|unique:tbloffices,office_name,$request->office_id",
    ]);
    $stmt = Office::where("officeId", $request->office_id)->update([
      "office_name" => $validated["officeName"]
    ]);
    return redirect()->back()->with("success", "Office updated successfully");
  }
}
