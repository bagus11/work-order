<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    use HasFactory;
    protected $table = 'master_categories';

    protected $guarded = [];
    public function departement(){
        return $this->hasOne(MasterDepartement::class,'id','departement_id');
    }
}
