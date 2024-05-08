<?php

namespace App\Models\Opex;

use App\Models\MasterKantor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpexHeader extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $table = 'category_inv';
    protected $guarded = [];
    function locationRelation() {
        return $this->hasOne(MasterKantor::class,'id','');
=======
    protected $table = 'opex_header';
    protected $guarded = [];
    function locationRelation() {
        return $this->hasOne(MasterKantor::class,'id','location_id');
    }
    function userRelation() {
        return $this->hasOne(User::class,'id', 'user_id');
>>>>>>> bc4183d9e4f9340ed5637337d9215f817bff3d51
    }
}
