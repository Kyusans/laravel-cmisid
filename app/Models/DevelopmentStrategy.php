<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevelopmentStrategy extends Model
{
    protected $table = 'tbldevelopmentstrategies';
    protected $primaryKey = 'devStrategy_id';

    protected $fillable = [
        'devStrategy_name'
    ];
}
