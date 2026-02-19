<?php

namespace App\Models;

use App\Models\Transaction\InformationSystem;
use Illuminate\Database\Eloquent\Model;

class DevelopmentStrategy extends Model
{
    protected $table = 'tbldevelopmentstrategies';
    protected $primaryKey = 'devStrategy_id';

    protected $fillable = [
        'devStrategy_name'
    ];

    public function informationSystems(){
        return $this->hasMany(InformationSystem::class, "infoSys_devStrategyId", "devStrategy_id");
    }
}
