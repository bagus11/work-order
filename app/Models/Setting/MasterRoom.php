<?php

namespace App\Models\Setting;

use App\Models\MasterKantor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRoom extends Model
{
    use HasFactory;
    protected $guarded = [];

    function locationRelation() {
        return $this->hasOne(MasterKantor::class, 'id', 'location_id');
    }
}
