<?php

namespace Database\Seeders;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "tblroles";
    protected $primaryKey = "role_id";

    protected function users()
    {
        return $this->hasMany(User::class, "user_role", "role_id");
    }
}
