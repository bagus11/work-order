<?php

namespace App\Models\OPX;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPXPO extends Model
{
    use HasFactory;
    protected $table = 'opxpo';
    protected $guarded = [];

    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
