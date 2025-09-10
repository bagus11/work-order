<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSystem extends Model
{
   use HasFactory;
    protected $guarded = [];

    function headerRelation() {
        return $this->belongsTo(UpdateSystem::class,'ticket_code','ticket_code');
    }
    function aspectRelation() {
        return $this->belongsTo(MasterAspek::class,'aspect','id');
    }
    function moduleRelation() {
        return $this->belongsTo(masterModule::class,'module','id');
    }
    function dataTypeRelation() {
        return $this->belongsTo(MasterSystem::class,'data_type','id');
    }
    function userRelation() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    function historyRelation(){
        return $this->hasMany(DetailSystemLog::class,'detail_code','detail_code');
    }

}
