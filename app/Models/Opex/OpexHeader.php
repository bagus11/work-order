<?php

namespace App\Models\Opex;

use App\Models\MasterKantor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpexHeader extends Model
{
    use HasFactory;
    protected $table = 'category_inv';
    protected $guarded = [];
    function locationRelation() {
        return $this->hasOne(MasterKantor::class,'id','');
    }
}
