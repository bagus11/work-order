<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterModule extends Model
{
    use HasFactory;
    protected $guarded = [];


    function aspekRelation() {
    return $this->hasOne(MasterAspek::class, 'id', 'aspek');
    }
}
