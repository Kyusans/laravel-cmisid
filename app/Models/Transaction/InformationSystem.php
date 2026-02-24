<?php

namespace App\Models\Transaction;

use App\Models\DevelopmentStrategy;
use App\Models\Office;
use App\Models\SystemStatus;
use App\Models\SystemType;
use App\Models\WorkingEnvironment;
use Illuminate\Database\Eloquent\Model;

class InformationSystem extends Model
{
    protected $table = "tblinformationsystems";

    protected $primaryKey = "infoSys_id";

    protected $fillable = [
        "infoSys_rank",
        "infoSys_isSmartCityInitiative",
        "infoSys_systemName",
        "infoSys_description",
        "infoSys_systemTypeId",
        "infoSys_officeId",
        "infoSys_systemStatusId",
        "infoSys_workEnvId",
        "infoSys_devStrategyId",
        "infoSys_hasPIA",
        "infoSys_datePia",
        "infoSys_initiationYear"
    ];

    public function systemType()
    {
        return $this->belongsTo(SystemType::class, "infoSys_systemTypeId", "systemType_id");
    }

    public function office()
    {
        return $this->belongsTo(Office::class, "infoSys_officeId", "office_id");
    }

    public function systemStatus()
    {
        return $this->belongsTo(SystemStatus::class, "infoSys_systemStatusId", "sysStatus_id");
    }

    public function workEnvironment()
    {
        return $this->belongsTo(WorkingEnvironment::class, "infoSys_workEnvId", "workEnv_id");
    }

    public function developmentStrategy()
    {
        return $this->belongsTo(DevelopmentStrategy::class, "infoSys_devStrategyId", "devStrategy_id");
    }

    // transaction relations

    public function systemProblems()
    {
        return $this->hasMany(SystemProblem::class, "sysprob_infoSysId", "infoSys_id");
    }

    public function infoSysDevelopers()
    {
        return $this->hasMany(InfoSysDeveloper::class, "infodev_infoSysId", "infoSys_id");
    }

    public function infoSysFundingSources()
    {
        return $this->hasMany(InfoSysFunding::class, "infoFund_id", "infoSys_id");
    }

    public function infoSysInternalUsers()
    {
        return $this->hasMany(InfoSysInternalUser::class, "infoInternal_infoSysId", "infoSys_id");
    }

    public function infoSysExternalUsers()
    {
        return $this->hasMany(InfoSysExternalUser::class, "infoExternal_infoSysId", "infoSys_id");
    }

    public function infoSysMfos()
    {
        return $this->hasMany(InfoSysMfo::class, "infoMfo_infoSysId", "infoSys_id");
    }
}
