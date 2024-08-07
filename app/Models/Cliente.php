<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    public function contratos()
    {
        return $this->hasMany(Contrato::class,'cliente_id');
    }

    public function contrato()
    {
        return $this->hasOne(Contrato::class,'cliente_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function dependentes()
    {
        return $this->hasMany(Dependentes::class);
    }


}
