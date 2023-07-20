<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');            
            $table->string("nome")->nullable();          
            $table->string("cidade")->nullable();
            $table->string("celular")->nullable();
            $table->string("telefone")->nullable();
            $table->string("email")->nullable();
            $table->string("cpf")->nullable();   
            $table->date("data_nascimento")->nullable(); 
            $table->string("cep")->nullable();  
            $table->string("rua")->nullable();
            $table->string("bairro")->nullable();
            $table->string("complemento")->nullable();
            $table->string("uf")->nullable();
            $table->string("cnpj")->nullable();
            $table->boolean('pessoa_fisica')->nullable();
            $table->boolean('pessoa_juridica')->nullable();
            $table->string('codigo_externo')->nullable();
            $table->string('nm_plano')->nullable();
            $table->string('numero_registro_plano')->nullable();    
            $table->string('rede_plano')->nullable();    
            $table->string('tipo_acomodacao_plano')->nullable();           
            $table->string('segmentacao_plano')->nullable();
            $table->string('cateirinha')->nullable();
            $table->int('quantidade_vidas')->nullable();
            $table->boolean('dados')->default(0);
            $table->date('baixa')->nullable();
            $table->boolean('dependente')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
