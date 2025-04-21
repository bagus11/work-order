<?php

namespace App\Models\Asset;

use App\Models\MasterAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    function assetRelation(){
        return $this->hasOne(MasterAsset::class, 'asset_code', 'asset_code');
    }

    
}
