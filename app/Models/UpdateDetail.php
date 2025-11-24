<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    function aspectRelation() {
            return $this->hasOne(MasterAspek::class, 'id', 'aspect');
    }
    function moduleRelation() {
            return $this->hasOne(masterModule::class, 'id', 'module');
    }
    function dataTypeRelation() {
            return $this->hasOne(MasterSystem::class, 'id', 'data_type');
    }
    function userRelation() {
            return $this->hasOne(User::class, 'id', 'user_id');
    }

}
