<?php

namespace App\Models;

use App\Models\Transaction\InfoSysRiseAgenda;
use Illuminate\Database\Eloquent\Model;

class RiseAgenda extends Model
{
   protected $table = "tblriseagendas";
   protected $primaryKey = "riseAgenda_id";

   protected $fillable = [
      "riseAgenda_name",
   ];

   public function infoSysRiseAgendas()
   {
      return $this->hasMany(InfoSysRiseAgenda::class, "infoAgenda_riseAgendaId", "riseAgenda_id");
   }
}
