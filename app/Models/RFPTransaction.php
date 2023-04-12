<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFPTransaction extends Model
{
    use HasFactory;
    protected $table = 'rfp_transaction';
    protected $guarded = [];


    public function location()
    {
        return $this->hasOne(MasterKantor::class,'id','office');
    }
    public function departementRelation()
    {
        return $this->hasOne(MasterDepartement::class,'id','departement');
    }
    public function userRelation()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function categoryRelation()
    {
        return $this->hasOne(MasterCategory::class,'id','category');
    }
    public function userTeam(){
        return $this->hasOne(MasterTeam::class,'id','teamId');
    }
    public function teamRelation()
    {
        return $this->hasOne(MasterTeam::class,'id','teamId');
    }
}
