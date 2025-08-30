<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Soap\Url;

class ApprovalMatrixDetail extends Model
{
    use HasFactory;
     protected $fillable = [
        'approval_code', 'step', 'user_id'
    ];

    function userRelation() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
