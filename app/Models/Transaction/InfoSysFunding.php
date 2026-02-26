<?php

namespace App\Models\Transaction;

use App\Models\FundingSource;
use Illuminate\Database\Eloquent\Model;

class InfoSysFunding extends Model
{
    protected $table = "tblinfosysfundings";
    protected $primaryKey = 'infoFund_id';
    protected $fillable = [
        "infoFund_fundingId",
        "infoFund_infoSysId"
    ];

    public function fundingSource()
    {
        return $this->belongsTo(FundingSource::class, "infoFund_fundingId", "funding_id");
    }

    public function informationSystem()
    {
        return $$this->belongsTo(InformationSystem::class, "infoFund_id", "infoSys_id");
    }

}
