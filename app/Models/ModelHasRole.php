<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class ModelHasRole extends Model
{
    use HasFactory,HasRoles;
    protected $table = 'model_has_roles';
    protected $primaryKey = 'permission_id';
    protected $fillable = [
        'role_id',
        'model_type',
        'model_id'
    ];
}
