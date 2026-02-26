<?php

namespace App\Models\Transaction;
use App\Models\Office;
use Illuminate\Database\Eloquent\Model;

class InfoSysInternalUser extends Model
{
    protected $table = "tblinfosysinternalusers";
    protected $primaryKey = "infoInternal_id";

    protected $fillable = [
        "infoInternal_officeId",
        "infoInternal_infoSysId"
    ];
    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "infoInternal_infoSysId", "infoSys_id");
    }

    public function officeId()
    {
        return $this->belongsTo(Office::class, "infoInternal_officeId", "office_id");
    }
}
