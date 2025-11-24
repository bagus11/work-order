<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateSystem extends Model
{
    use HasFactory;
    protected $guarded = [];

    function userRelation() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    function approverRelation() {
        return $this->belongsTo(User::class,'approval_id','id');
    }
    function detailRelation() {
        return $this->hasMany(DetailSystem::class,'ticket_code','ticket_code');
    }
    function historyRelation(){
        return $this->hasMany(UpdateSystemLog::class,'ticket_code','ticket_code');
    }

}
