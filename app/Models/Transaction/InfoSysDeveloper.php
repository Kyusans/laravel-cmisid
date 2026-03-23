<?php

namespace App\Models\Transaction;

use App\Models\Developer;
use Illuminate\Database\Eloquent\Model;

class InfoSysDeveloper extends Model
{
    protected $table = "tblinfosysdevelopers";
    protected $primaryKey = 'infodev_id';

    protected $fillable = [
        'infoDev_devId',
        'infoDev_infoSysId'
    ];

    public function developer()
    {
        return $this->belongsTo(Developer::class, "infoDev_devId", "dev_id");
    }

    public function informationSystem()
    {
        return $this->belongsTo(InformationSystem::class, "infoDev_infoSysId", "infoSys_id");
    }
}
