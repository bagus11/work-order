<?php

namespace App\Models;

use App\Models\Asset\BrandAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificatonModel extends Model
{
    use HasFactory;
    protected $table = 'pc_spec';
    protected $guarded = [];

    function assetRelation() {
        return $this->hasOne(MasterAsset::class, 'asset_code', 'asset_code');
    }

    function brandRelation() {
        return $this->hasOne(BrandAsset::class, 'name', 'brand');
    }
}
