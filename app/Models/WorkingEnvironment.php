<?php

namespace App\Models;

use App\Models\Transaction\InformationSystem;
use Illuminate\Database\Eloquent\Model;

class WorkingEnvironment extends Model
{
    protected $table = "tblworkingenvironments";
    protected $primaryKey = 'workEnv_id';

    protected $fillable = [
        "workEnv_name",
        "workEnv_description"
    ];

    public function informationSystems()
    {
        return $this->hasMany(InformationSystem::class, "infoSys_workEnvId", "workEnv_id");
    }
}
