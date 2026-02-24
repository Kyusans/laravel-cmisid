<?php

namespace App\Models;

use App\Models\Transaction\InfoSysPpa;
use Illuminate\Database\Eloquent\Model;

class Ppa extends Model
{
    protected $table = 'tblppa';
    protected $primaryKey = 'ppa_id';

    protected $fillable = [
        'ppa_name'
    ];

    public function infoSysPpas()
    {
        return $this->hasMany(InfoSysPpa::class, "infoPpa_ppaId", "ppa_id");
    }
}
