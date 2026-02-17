<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalUser extends Model
{
    protected $table = 'tblexternalusers';
    protected $primaryKey = 'external_id';

    protected $fillable = [
        'external_name',
    ];
}
