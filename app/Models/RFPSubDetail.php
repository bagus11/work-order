<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFPSubDetail extends Model
{
    use HasFactory;
    protected $table = 'rfp_subdetails';
    protected $guarded = [];

    public function userRelation()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function rfpDetailRelation()
    {
        return $this->hasOne(RFPDetail::class,'detail_code','detail_code');
    }
}
