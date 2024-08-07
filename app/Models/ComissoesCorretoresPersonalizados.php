<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissoesCorretoresPersonalizados extends Model
{
    use HasFactory;

    protected $table = "comissoes_corretores_personalizado";
    public $timestamps = false;

    public function planos()
    {
        return $this->belongsTo(Planos::class,'plano_id','id');
    }

    public function administradoras()
    {
        return $this->belongsTo(Administradoras::class,'administradora_id','id');
    }

}
