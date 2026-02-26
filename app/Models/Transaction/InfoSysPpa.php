<?php

namespace App\Models\Transaction;

use App\Models\Ppa;
use Illuminate\Database\Eloquent\Model;

class InfoSysPpa extends Model
{
    protected $table = 'tblinfosysppa';
    protected $primaryKey = 'infoPpa_id';

    protected $fillable = [
        "infoPpa_ppaId",
        "infoPpa_infoSysId"
    ];

    public function informationSystem(){
        return $this->belongsTo(InformationSystem::class, "infoPpa_infoSysId", "infoSys_id");
    }

    public function ppa(){
        return $this->belongsTo(Ppa::class, "infoPpa_ppaId", "ppa_id");
    }
}
