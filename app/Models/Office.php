<?php

namespace App\Models;

use App\Models\Transaction\InformationSystem;
use App\Models\Transaction\InfoSysExternalUser;
use App\Models\Transaction\InfoSysInternalUser;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "tbloffices";
    protected $primaryKey = "office_id";

    protected $fillable = [
        "office_name"
    ];

    public function users()
    {
        return $this->hasMany(User::class, "user_officeId", "office_id");
    }

    public function developers()
    {
        return $this->hasMany(Developer::class, "developer_officeId", "office_id");
    }

    public function informationSystems()
    {
        return $this->hasMany(InformationSystem::class, "infoSys_officeId", "office_id");
    }

    public function mfos()
    {
        return $this->hasMany(Mfo::class, "mfo_officeId", "office_id");
    }

    public function ppas()
    {
        return $this->hasMany(Ppa::class, "ppa_officeId", "office_id");
    }

    public function infoSysInternalUsers()
    {
        return $this->hasMany(InfoSysInternalUser::class, "infoInternal_officeId", "office_id");
    }

    public function infoSysExternalUsers()
    {
        return $this->hasMany(InfoSysExternalUser::class, "infoExternal_officeId", "office_id");
    }
}
