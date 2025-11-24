<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalMatrix extends Model
{
    use HasFactory;
    protected $fillable = [
        'approval_code', 'step', 'aspect', 'module', 'data_type'
    ];

    public function details()
    {
        return $this->hasMany(ApprovalMatrixDetail::class, 'approval_code', 'approval_code');
    }

    function aspectRelation() {
        return $this->hasOne(MasterAspek::class, 'id', 'aspect');
    }
    function moduleRelation() {
        return $this->hasOne(masterModule::class, 'id', 'module');
    }
    function dataTypeRelation() {
        return $this->hasOne(MasterSystem::class, 'id', 'data_type');
    }
}
