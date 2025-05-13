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
    public function picName()
    {
        return $this->hasOne(User::class,'id', 'user_id');
    }
    public function departementName()
    {
        return $this->hasOne(MasterDepartement::class, 'id','departement_id');
    }
    public function categoryName()
    {
        return $this->hasOne(MasterCategory::class, 'id','category');
    }
    public function problemTypeName()
    {
        return $this->hasOne(ProblemType::class, 'id','problem_type');
    }
    function detailWORelation() {
        return $this->hasMany(WorkOrderLog::class,'request_code','request_code');
    }
}
