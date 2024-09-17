<?php

namespace App\Models\RFP;

use App\Models\RFPTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    use HasFactory;
    protected $table = 'chat_model';
    protected $guarded = [];
    public function userRelation()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
