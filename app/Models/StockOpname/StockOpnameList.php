<?php

namespace App\Models\StockOpname;

use App\Models\MasterAsset;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpnameList extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_code',
        'asset_code',
        'location_id',
        'updated_by',
        'attachment',
        'notes',
        'status',
    ];
    function assetRelation(){
        return $this->belongsTo(MasterAsset::class,'asset_code','asset_code');
    }
    function userRelation() {
        return $this->hasOne(User::class,'id', 'updated_by');
    }
}
