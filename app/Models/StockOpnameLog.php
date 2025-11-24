<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameLog extends Model
{
    use HasFactory;
     protected $guarded = [];

      function userRelation(){
        return $this->hasOne(User::class, 'id', 'user_id');
     }
     function locationRelation(){
        return $this->hasOne(MasterKantor::class, 'id', 'location_id');
     }
}
