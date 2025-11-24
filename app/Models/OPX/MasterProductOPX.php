<?php

namespace App\Models\OPX;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProductOPX extends Model
{
    use HasFactory;
    protected $table = 'master_product_opx';
    protected $guarded = [];

    function categoryRelation() {
        return $this->hasOne(MasterCategoryOPX::class, 'id','category');
    }
}
