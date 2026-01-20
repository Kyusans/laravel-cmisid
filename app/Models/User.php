<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "tblusers";
    protected $primaryKey = "user_id";

    protected $fillable = [
        "user_firstName",
        "user_middleName",
        "user_lastName",
        "user_email",
        "user_password",
        "user_role"
    ];

    protected $hidden = [
        "user_password",
        "remember_token"
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, "user_role", "role_id");
    }
}
