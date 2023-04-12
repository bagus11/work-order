<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFPDetail extends Model
{
    use HasFactory;
    protected $table = 'rfp_details';
    protected $guarded = [];
    public function userRelation()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function rfpRelation(){
        return $this->hasOne(RFPTransaction::class,'request_code','request_code');
    }
}
