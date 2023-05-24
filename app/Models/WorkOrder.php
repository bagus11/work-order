<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;
    protected $table = 'work_orders';
    protected $guarded = [];

    public function picSupportName()
    {
        return $this->hasOne(User::class,'id', 'user_id_support');
    }
}
