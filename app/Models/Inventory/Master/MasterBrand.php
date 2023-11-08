<?php

namespace App\Models\Inventory\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBrand extends Model
{
    use HasFactory;
    protected $table = 'master_brand';
    protected $guarded = [];
}
