<?php

namespace App\Models\Inventory\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTypeModel extends Model
{
    use HasFactory;
    protected $table = 'master_type';
    protected $guarded = [];
}
