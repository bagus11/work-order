<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAssetLog extends Model
{
    use HasFactory;
    protected $table = 'master_asset_log';
    protected $guarded = [];
    function userRelation() {
        return $this->hasOne(User::class,'nik','nik');
    }

    function creatorRelation() {
        return $this->hasOne(User::class,'nik','user_id');
    }
}
