<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSystemLog extends Model
{
    use HasFactory;
    protected $guarded =[];

    function detailRelation() {
        return $this->belongsTo(DetailSystem::class,'detail_code','detail_code');
    }
    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
