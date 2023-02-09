<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderLog extends Model
{
    use HasFactory;
    protected $table = 'work_order_logs';
    protected $guarded = [];

    public function userPIC(){
        return $this->hasOne(User::class, 'id','creator');
    }
    public function userPICSupport()
    {
        return $this->hasOne(User::class, 'id', 'user_id_support');
    }
}
