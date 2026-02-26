<?php

namespace App\Models;

use App\Models\Transaction\InfoSysFunding;
use Illuminate\Database\Eloquent\Model;

class FundingSource extends Model
{
    protected $table = "tblfundingsource";
    protected $primaryKey = "funding_id";
    protected $fillable = [
        'funding_name',
    ];

    public function infoSysFunding()
    {
        return $this->hasMany(InfoSysFunding::class, "infoFund_fundingId", "funding_id");
    }
}
