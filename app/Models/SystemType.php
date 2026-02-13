<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemType extends Model
{
    protected $table = 'tblsystemtypes';
    protected $primaryKey = "systemType_id";

    protected $fillable =[
    "systemType_name",
    "systemType_description"
    ];

    
}
