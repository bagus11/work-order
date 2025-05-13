<?php

namespace App\Models\Asset;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalDetail extends Model
{
    use HasFactory;
    protected $table = 'approval_details';
    protected $guarded = [];

    function userRelation() {
        return $this->hasOne(User::class,'nik','nik');
    }

}
