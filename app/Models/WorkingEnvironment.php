<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingEnvironment extends Model
{
    protected $table = "tblworkingenvironments";
    protected $primaryKey = 'workEnv_id';

    protected $fillable = [
        "workEnv_name",
        "workEnv_description"
    ];
}
