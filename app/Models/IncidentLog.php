<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentLog extends Model
{
    use HasFactory;
    protected $table ='incident_logs';
    protected $guarded = [];
    function UserRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function headerRelation() {
        return $this->hasOne(IncidentHeader::class,'incident_code','incident_code');
    }
}
