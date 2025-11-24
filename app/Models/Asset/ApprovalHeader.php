<?php

namespace App\Models\Asset;

use App\Models\MasterDepartement;
use App\Models\MasterKantor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalHeader extends Model
{
    use HasFactory;
    protected $table = 'approval_headers';
    protected $guarded = [];
    
    function detailRelation()
    {
        return $this->hasMany(ApprovalDetail::class, 'approval_code', 'approval_code');
    }
    function locationRelation(){
        return $this->hasOne(MasterKantor::class,'id', 'location_id');
    }
    function departmentRelation() {
        return $this->hasOne(MasterDepartement::class, 'id', 'department');
    }
}
