<?php

namespace App\Models\Asset;

use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    function locationRelation()
    {
        return $this->hasOne(MasterKantor::class, 'id', 'location_id');
    }
    function desLocationRelation()
    {
        return $this->hasOne(MasterKantor::class, 'id', 'des_location_id');
    }
    function picRelation() {
        return $this->hasOne(User::class, 'id', 'pic_id');
    }
    function userRelation()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    function receiverRelation()
    {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }
    function approvalRelation()
    {
        return $this->hasOne(User::class, 'id', 'approval_id');
    }
}
