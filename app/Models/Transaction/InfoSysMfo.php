<?php

namespace App\Models\Transaction;

use App\Models\Mfo;
use Illuminate\Database\Eloquent\Model;

class InfoSysMfo extends Model
{
    protected $table = "tblinfosysmfo";
    protected $primaryKey = "infoMfo_id";

    protected $fillable = [
        "infoMfo_mfoId",
        "infoMfo_infoSysId",
        "infoMfo_connectWithMFO"
    ];

    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "infoMfo_infoSysId", "infoSys_id");
    }

    public function mfo()
    {
        return $this->belongsTo(Mfo::class, "infoMfo_mfoId", "mfo_id");
    }
}
