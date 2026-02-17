<?php

namespace App\Http\Controllers\Masterfiles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserMasterController extends Controller
{

	public function addUser(Request $request)
	{
		// {"userFirstName":"Bea Ysabel", "userMiddleName":"Macalua", "userLastName":"Lachica", "userEmail":"bealachica@gmail.com", "userPassword":"beagwapa", "userOfficeId":"2", "userRoleId":"1"}   
		$validated = $request->validate([
			"userFirstName" => "required|string",
			"userMiddleName" => "nullable|string",
			"userLastName" => "required|string",
			"userEmail" => "required|email|unique:tblusers,user_email",
			"userPassword" => "required|string|min:8",
			"userOfficeId" => "required|integer|exists:tbloffices,office_id",
			"userRoleId" => "required|integer|exists:tblroles,role_id",
		]);
		User::create([
			"user_firstName" => $validated["userFirstName"],
			"user_middleName" => $validated["userMiddleName"],
			"user_lastName" => $validated["userLastName"],
			"user_email" => $validated["userEmail"],
			"user_password" => $validated["userPassword"],
			"user_officeId" => $validated["userOfficeId"],
			"user_roleId" => $validated["userRoleId"],
		]);
		return redirect('/create/user')->with('success','User added successfully');
	}

	public function updateUser(Request $request)
	{
		// {"userId": 3, "userFirstName": "Bea Ysabel", "userMiddleName": "Macalua", "userLastName": "Lacheca", "userOfficeId": 2,"userRoleId": 1}
		$validated = $request->validate([
			"userId" => "required",
			"userFirstName" => "required|string",
			"userMiddleName" => "nullable|string",
			"userLastName" => "required|string",
			// "userEmail" => "required|email|unique:tblusers,user_email,$request->userId,user_id",
			// "userPassword" => "required|string|min:8",
			"userOfficeId" => "required|integer|exists:tbloffices,office_id",
			"userRoleId" => "required|integer|exists:tblroles,role_id",
		]);
		User::where("user_id", $request->userId)
			->update([
				"user_firstName" => $validated["userFirstName"],
				"user_middleName" => $validated["userMiddleName"],
				"user_lastName" => $validated["userLastName"],
				// "user_email" => $validated["userEmail"],
				// "user_password" => $validated["userPassword"],
				"user_officeId" => $validated["userOfficeId"],
				"user_roleId" => $validated["userRoleId"],
			]);
		session()->flash("success", "Users updated successfully");
	}
}
