<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissoesCorretoresParceiros extends Model
{
    use HasFactory;
    protected $table = "comissoes_corretores_parceiros";
    public $timestamps = false;

    public function planos()
    {
        return $this->belongsTo(Planos::class,'plano_id','id');
    }

    public function administradoras()
    {
        return $this->belongsTo(Administradoras::class,'administradora_id','id');
    }

    public function cidades()
    {
        return $this->belongsTo(TabelaOrigens::class,'tabela_origens_id','id');
    }







}
