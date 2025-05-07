<?php

namespace App\Models\Asset;

use App\Models\MasterAsset;
use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    function locationRelation()
    {
        return $this->hasOne(MasterKantor::class, 'id', 'location_id');
    }
    function userRelation()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    function assetRelation()
    {
        return $this->hasOne(MasterAsset::class, 'asset_code', 'asset_code');
    }
    function historyRelation()
    {
        return $this->hasMany(ServiceLog::class, 'service_code', 'service_code');
    }
}
