<?php

namespace App\Models;

use App\Models\Transaction\InfoSysExternalUser;
use Illuminate\Database\Eloquent\Model;

class ExternalUser extends Model
{
    protected $table = 'tblexternalusers';
    protected $primaryKey = 'external_id';

    protected $fillable = [
        'external_name',
    ];

    public function infoSysExternalUsers()
    {
        return $this->hasMany(InfoSysExternalUser::class, "infoExternal_externalId", "external_id");
    }
}
