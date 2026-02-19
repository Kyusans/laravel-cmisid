<?php

namespace App\Models;

use App\Models\Transaction\InformationSystem;
use Illuminate\Database\Eloquent\Model;

class SystemStatus extends Model
{
    protected $table = "tblsystemstatus";
    protected $primaryKey = 'sysStatus_id';

    protected $fillable = [
        'sysStatus_name',
    ];

    public function informationSystems()
    {
        return $this->hasMany(InformationSystem::class, "infoSys_systemStatusId", "sysStatus_id");
    }
}
