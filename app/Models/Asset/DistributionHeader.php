<?php

namespace App\Models\Asset;

use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionHeader extends Model
{
    use HasFactory;
    protected $guarded = [];
    function detailRelation()
    {
        return $this->hasMany(DistributionDetail::class, 'request_code', 'request_code');
    }
    function locationRelation()
    {
        return $this->hasOne(MasterKantor::class, 'id', 'location_id');
    }
    function desLocationRelation()
    {
        return $this->hasOne(MasterKantor::class, 'id', 'des_location_id');
    }
    function userRelation()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    function currentRelation() {
        return $this->hasOne(User::class, 'id', 'pic_id');
    }
    function receiverRelation()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }
    function historyRelation() {
        return $this->hasMany(DistributionLog::class, 'request_code', 'request_code');
    }
}
