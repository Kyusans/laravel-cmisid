<?php

namespace App\Models\Transaction;

use App\Models\ExternalUser;
use Illuminate\Database\Eloquent\Model;

class InfoSysExternalUser extends Model
{
    protected $table = "tblinfosysexternalusers";
    protected $primaryKey = 'infoExternal_id';

    protected $fillable = [
        "infoExternal_externalId",
        "infoExternal_infoSysId"
    ];

    public function informationSystem(){
        return $this->belongsTo(InformationSystem::class, "infoExternal_infoSysId", "infoSys_id");
    }

    public function externalUser(){
        return $this->belongsTo(ExternalUser::class, "infoExternal_externalId", "external_id");
    }
}
