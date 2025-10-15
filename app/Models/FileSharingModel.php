<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingModel extends Model
{
    use HasFactory;
    protected $guarded =[];

    function userRelation() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function departmentRelation(){
        return $this->hasOne(MasterDepartement::class, 'id', 'department_id');
    }

    function historyRelation() {
          return $this->hasMany(FileSharingLog::class, 'file_id', 'id');
    }
}
