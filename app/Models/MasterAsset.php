<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAsset extends Model
{
    use HasFactory;
    protected $table = 'master_asset';

    function userRelation() {
        return $this->hasOne(User::class,'nik','nik');
    }
    function historyRelation() {
        return $this->hasMany(MasterAssetLog::class,'asset_code', 'asset_code');
    }
    function specRelation() {
        return $this->hasOne(SpecificatonModel::class, 'asset_code', 'asset_code');
    }

}
