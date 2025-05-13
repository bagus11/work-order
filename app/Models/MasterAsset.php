<?php

namespace App\Models;

use App\Models\Asset\BrandAsset;
use App\Models\Asset\CategoryAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAsset extends Model
{
    use HasFactory;
    protected $table = 'master_asset';
    protected $guarded = [];
    function userRelation() {
        return $this->hasOne(User::class,'nik','nik');
    }
    function historyRelation() {
        return $this->hasMany(MasterAssetLog::class,'asset_code', 'asset_code');
    }
    function specRelation() {
        return $this->hasOne(SpecificatonModel::class, 'asset_code', 'asset_code');
    }
    function categoryRelation() {
        return $this->hasOne(CategoryAsset::class, 'name', 'category');
    }
    function brandRelation() {
        return $this->hasOne(BrandAsset::class, 'name', 'brand');
    }
    function locationRelation() {
        return $this->hasOne(MasterKantor::class, 'id', 'location_id');
    }
    function ownerRelation() {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

}
