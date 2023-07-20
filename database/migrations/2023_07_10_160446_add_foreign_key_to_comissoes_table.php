<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToComissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('comissoes', function (Blueprint $table) {
            $table->unsignedBigInteger('contrato_empresarial_id')->after('contrato_id')->nullable();
            $table->foreign('contrato_empresarial_id')->references('id')->on('contrato_empresarial')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comissoes', function (Blueprint $table) {
            $table->dropForeign('comissoes_contrato_empresarial_id_foreign');
            $table->dropColumn('contrato_empresarial_id');
        });
    }
}
