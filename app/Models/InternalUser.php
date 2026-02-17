<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalUser extends Model
{
    protected $table = "tblinternalusers";
    protected $primaryKey = 'internal_id';

    protected $fillable = [
        "internal_name"
    ];
}
