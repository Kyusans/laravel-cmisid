<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundingSource extends Model
{
    protected $table = "tblfundingsource";
    protected $primaryKey = "funding_id";
    protected $fillable = [
        'funding_name',
    ];
}
