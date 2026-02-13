<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemStatus extends Model
{
    protected $table = "tblsystemstatus";
    protected $primaryKey = 'sysStatus_id';

    protected $fillable = [
        'sysStatus_name',
    ];
}
