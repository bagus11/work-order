<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    function assetRelation(){
        return $this->hasOne(MasterAsset::class, 'asset_code', 'asset_code');
    }
}
