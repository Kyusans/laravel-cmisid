<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ppa extends Model
{
    protected $table = 'tblppa';
    protected $primaryKey = 'ppa_id';

    protected $fillable = [
        'ppa_name'
    ];
}
