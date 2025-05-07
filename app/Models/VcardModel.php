<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VcardModel extends Model
{
    use HasFactory;

    function userRelation() {
        return $this->hasOne(User::class,'nik', 'nik');
    }
}
