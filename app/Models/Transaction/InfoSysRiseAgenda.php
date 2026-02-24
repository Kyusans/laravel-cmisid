<?php

namespace App\Models\Transaction;

use App\Models\RiseAgenda;
use Illuminate\Database\Eloquent\Model;

class InfoSysRiseAgenda extends Model
{
    protected $table = 'tblinfosysriseagenda';
    protected $primaryKey = 'infoAgenda_id';

    protected $fillable = [
        "infoAgenda_riseAgendaId",
        "infoAgenda_infoSysId"
    ];


    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "infoAgenda_infoSysId", "infoSys_id");
    }

    public function riseAgenda()
    {
        return $this->belongsTo(RiseAgenda::class, "infoAgenda_riseAgendaId", "riseAgenda_id");
    }
}
