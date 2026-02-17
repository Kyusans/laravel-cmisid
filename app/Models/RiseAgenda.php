<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiseAgenda extends Model
{
 protected $table = "tblriseagendas";
 protected $primaryKey = "riseAgenda_id";

 protected $fillable = [
    "riseAgenda_name",
 ];
}
