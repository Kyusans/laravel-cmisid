<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

class SystemProblem extends Model
{
    protected $table = "tblsystemproblems";
    protected $primaryKey = 'sysprob_id';
    protected $fillable = [
        "sysprob_problem",
        "sysprob_infoSysId"
    ];

    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "sysprob_infoSysId", "infoSys_id");
    }
}
