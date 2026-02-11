<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "tblusers";
    protected $primaryKey = "user_id";

    protected $fillable = [
        "user_firstName",
        "user_middleName",
        "user_lastName",
        "user_email",
        "user_password",
        'user_officeId',
        "user_roleId",
    ];

    protected $hidden = [
        "user_password",
        "remember_token"
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    protected function role()
    {
        return $this->belongsTo(Role::class, "user_roleId", "role_id");
    }

    protected function office()
    {
        return $this->belongsTo(Office::class, "user_officeId", "office_id");
    }

    protected function setUserPasswordAttribute($value)
    {
        $this->attributes["user_password"] = bcrypt($value);
    }
}
