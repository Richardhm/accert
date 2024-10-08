<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\UserACLTrait;

class User extends Authenticatable
{
    use HasFactory, Notifiable, UserACLTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cargo_id',
        'cpf',
        'endereco',
        'cidade',
        'estado',
        'celular',
        'numero',
        'image',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'user_id');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function comissoesValoresCorretores()
    {
        return $this->hasMany(ValoresCorretoresLancados::class);
    }

    public function comissoes()
    {
        return $this->hasMany(comissoes::class);
    }




    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
