<?php

namespace App\Models\OPX;

use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringOPX extends Model
{
    use HasFactory;
    protected $table = 'monitoring_opx';
    protected $guarded = [];

    function categoryRelation() {
        return $this->hasOne(MasterCategoryOPX::class, 'id','category');
    }
    function locationRelation() {
        return $this->hasOne(MasterKantor::class,'id', 'location');
    }
    function productRelation(){
        return $this->hasOne(MasterProductOPX::class,'id', 'product');
    }
    function userRelation() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
