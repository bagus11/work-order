<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTeam extends Model
{
    use HasFactory;
    protected $table ='master_teams';
    protected $guarded = [];

    public function detailRelation()
    {
        return $this->belongsTo(DetailTeam::class,'id');
    }
}
