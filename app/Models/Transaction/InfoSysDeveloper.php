<?php

namespace App\Models\Transaction;

use App\Models\Developer;
use Illuminate\Database\Eloquent\Model;

class InfoSysDeveloper extends Model
{
    protected $table = "tblinfosysdevelopers";
    protected $primaryKey = 'infodev_id';

    protected $fillable = [
        "infodev_devId",
        "infodev_infoSysId"
    ];

    public function developer()
    {
        return $this->belongsTo(Developer::class, "infodev_devId", "dev_id");
    }

    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "infodev_infoSysId", "infoSys_id");
    }
}
