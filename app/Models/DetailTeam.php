<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTeam extends Model
{
    use HasFactory;
    protected $table ='detail_teams';
    protected $guarded = [];

    public function User()
    {
        return $this->hasOne(User::class, 'userId', 'id');
    }
}
