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
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'creator');
    }
    public function priority(){
        return $this->hasOne(MasterPriority::class,'id','priority');
    }
}
