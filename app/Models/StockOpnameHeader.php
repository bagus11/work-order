<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameHeader extends Model
{
    use HasFactory;
     protected $guarded = [];


     function userRelation(){
        return $this->hasOne(User::class, 'id', 'user_id');
     }
     function locationRelation(){
        return $this->hasOne(MasterKantor::class, 'id', 'location_id');
     }
     function departmentRelation(){
        return $this->hasOne(MasterDepartement::class, 'id', 'department_id');
     }
     function historyRelation(){
        return $this->hasMany(StockOpnameLog::class, 'ticket_code', 'ticket_code');
     }
}
