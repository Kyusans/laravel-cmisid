<?php

namespace App\Models\Transaction;

use App\Models\InternalUser;
use Illuminate\Database\Eloquent\Model;

class InfoSysInternalUser extends Model
{
    protected $table = "tblinfosysinternalusers";
    protected $primaryKey = "infoInternal_id";

    protected $fillable = [
        "infoInternal_internalId",
        "infoInternal_infoSysId"
    ];

    public function internalUser()
    {
        return $this->belongsTo(InternalUser::class, "infoInternal_internalId", "internal_id");
    }

    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "infoInternal_infoSysId", "infoSys_id");
    }
}
