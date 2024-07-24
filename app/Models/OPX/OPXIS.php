<?php

namespace App\Models\OPX;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPXIS extends Model
{
    use HasFactory;
    protected $table = 'opxis';
    protected $guarded = [];

    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
}
