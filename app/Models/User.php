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
        "user_birthdate",
        "user_role",
        "user_status"
    ];

    protected $hidden = [
        "user_password",
        "remember_token"
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, "user_role", "role_id");
    }

    public function setUserPasswordAttribute($value)
    {
        $this->attributes["user_password"] = bcrypt($value);
    }
}
