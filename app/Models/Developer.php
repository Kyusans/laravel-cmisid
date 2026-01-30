<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $table = "tbldevelopers";
    protected $primaryKey = "dev_id";

    protected $fillable = [
        "dev_firstName",
        "dev_middleName",
        "dev_lastName",
        "dev_officeId",
        "dev_specId",
    ];

    public function office()
    {
        return $this->belongsTo(Office::class, "dev_officeId", "office_id");
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, "dev_specId", "spec_id");
    }
}
