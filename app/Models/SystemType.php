<?php

namespace App\Models;

use App\Models\Transaction\InformationSystem;
use Illuminate\Database\Eloquent\Model;

class SystemType extends Model
{
    protected $table = 'tblsystemtypes';
    protected $primaryKey = "systemType_id";

    protected $fillable = [
        "systemType_name",
        "systemType_description"
    ];

    public function informationSystems()
    {
        return $this->hasMany(InformationSystem::class, "infoSys_systemTypeId", "systemType_id");
    }
}
