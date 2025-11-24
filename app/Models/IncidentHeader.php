<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentHeader extends Model
{
    use HasFactory;
    protected $table ='incident_headers';
    protected $guarded = [];
   
    function problemRelation() {
        return $this->hasOne(ProblemType::class,'id','incident_problem');
    }
    function categoriesRelation() {
        return $this->hasOne(MasterCategory::class,'id','incident_category');
    }
    function locationRelation() {
        return $this->hasOne(MasterKantor::class,'id','kode_kantor');
    }
    function UserRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
