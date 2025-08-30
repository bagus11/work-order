<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateSystemLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_code',
        'user_id',
        'approval_code',
        'step',
        'status',
        'duration',
        'remark',
    ];
    
}
