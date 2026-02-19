<?php

namespace App\Models;

use App\Models\Transaction\InfoSysInternalUser;
use Illuminate\Database\Eloquent\Model;

class InternalUser extends Model
{
    protected $table = "tblinternalusers";
    protected $primaryKey = 'internal_id';

    protected $fillable = [
        "internal_name"
    ];

    public function infoSysInternalUsers()
    {
        return $this->hasMany(InfoSysInternalUser::class, "infoInternal_internalId", "internal_id");
    }
}
