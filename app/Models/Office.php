<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "tbloffices";
    protected $primaryKey = "office_id";

    protected $fillable = [
        "office_name"
    ];

    protected function users(){
        return $this->hasMany(User::class, "user_officeId", "office_id");
    }

    protected function developers(){
        return $this->hasMany(Developer::class, "developer_officeId", "office_id");
    }
    
}
