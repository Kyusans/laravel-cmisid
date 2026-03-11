<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiseAgendaType extends Model
{
    protected $table = "tblriseagendatypes";
    protected $primaryKey = 'agendaType_id';

    protected $fillable = [
        "agendaType_name",
    ];

    public function riseAgendas()
    {
        return $this->hasMany(RiseAgenda::class, "riseAgenda_agendaTypeId", "agendaType_id");
    }
}
