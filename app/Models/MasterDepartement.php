<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDepartement extends Model
{
    use HasFactory;
    protected $table = 'master_departements';

    protected $guarded = [];
}
