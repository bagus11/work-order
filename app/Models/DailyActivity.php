<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;
    protected $table = 'daily_activities';
    protected $guarded = [];
    public function userRelation()
    {
        return $this->hasOne(User::class,'id','userId');
    }
}
