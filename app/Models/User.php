<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'nik',
        'password',
        'flg_aktif',
        'jabatan',
        'departement',
        'kode_kantor',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Departement()
    {
        return $this->hasOne(MasterDepartement::class,'id','departement');
    }
    public function Jabatan()
    {
        return $this->hasOne(MasterJabatan::class,'id','jabatan');
    }
    public function DetailTeam()
    {
        return $this->hasOne(DetailTeam::class,'id','userId');
    }
    function locationRelation() {
        return $this->hasOne(MasterKantor::class,'id','kode_kantor');
    }
    public function departmentRelation()
    {
        return $this->hasOne(MasterDepartement::class,'id','departement');
    }
}
