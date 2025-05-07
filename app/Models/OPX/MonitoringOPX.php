<?php

namespace App\Models\OPX;

use App\Models\MasterKantor;
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

}
