<?php

namespace App\Models\Transaction;

use App\Models\Office;
use Illuminate\Database\Eloquent\Model;

class InfoSysExternalUser extends Model
{
    protected $table = "tblinfosysexternalusers";
    protected $primaryKey = 'infoExternal_id';

    protected $fillable = [
        "infoExternal_officeId",
        "infoExternal_infoSysId"
    ];

    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "infoExternal_infoSysId", "infoSys_id");
    }

    public function office()
    {
        return $this->belongsTo(Office::class, "infoExternal_officeId", "office_id");
    }
}
