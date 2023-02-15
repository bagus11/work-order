<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WONotification extends Model
{
    use HasFactory;
    protected $table = 'wo_notifications';
    protected $guarded = [];
}
