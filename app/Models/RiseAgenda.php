<?php

namespace App\Models;

use App\Models\Transaction\InfoSysRiseAgenda;
use App\Models\RiseAgendaType;
use Illuminate\Database\Eloquent\Model;

class RiseAgenda extends Model
{
   protected $table = "tblriseagendas";
   protected $primaryKey = "riseAgenda_id";

   protected $fillable = [
      "riseAgenda_name",
      "riseAgenda_description",
      "riseAgenda_agendaTypeId",
   ];

   public function infoSysRiseAgendas()
   {
      return $this->hasMany(InfoSysRiseAgenda::class, "infoAgenda_riseAgendaId", "riseAgenda_id");
   }

   public function riseAgendaType()
   {
      return $this->belongsTo(RiseAgendaType::class, "riseAgenda_agendaTypeId", "agendaType_id");
   }
}
