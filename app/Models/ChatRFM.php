<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRFM extends Model
{
    use HasFactory;
    protected $table = 'chat_rfm';
    protected $guarded = [];

    function userRelation(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
