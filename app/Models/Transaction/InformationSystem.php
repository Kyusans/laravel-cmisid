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
}
