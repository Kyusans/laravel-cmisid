<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mfo extends Model
{
    protected $table = "tblmfo";
    protected $primaryKey = "mfo_id";

    protected $fillable = [
        "mfo_name"
    ];
}
