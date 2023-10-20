<?php

namespace App\Models\Inventory\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterInvCategory extends Model
{
    use HasFactory;
    protected $table = 'category_inv';
    protected $guarded = [];

    function typeRelation() {
        return $this->hasOne(MasterTypeModel::class,'id','type_id');
    }
}
