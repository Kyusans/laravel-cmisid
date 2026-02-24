<?php

namespace App\Models;

use App\Models\Transaction\InfoSysMfo;
use Illuminate\Database\Eloquent\Model;

class Mfo extends Model
{
    protected $table = "tblmfo";
    protected $primaryKey = "mfo_id";

    protected $fillable = [
        "mfo_name"
    ];

    public function infoSysMfos()
    {
        return $this->hasMany(InfoSysMfo::class, "infoMfo_mfoId", "mfo_id");
    }
}
