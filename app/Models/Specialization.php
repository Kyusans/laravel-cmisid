<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $table = "tblspecializations";
    protected $primaryKey = "spec_id";

    protected $fillable = [
        "spec_name",
    ];

    public function developers()
    {
        return $this->hasMany(Developer::class, "dev_specId", "spec_id");
    }
}
