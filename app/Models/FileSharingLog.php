<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingLog extends Model
{
    use HasFactory;
    protected $guarded =[];

    function userRelation() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
   
}
