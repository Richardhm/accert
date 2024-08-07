<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorretoraIdToContratoEmpresarialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contrato_empresarial', function (Blueprint $table) {
            $table->foreignId('corretora_id')->default(1)->after('id')->constrained('corretoras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contrato_empresarial', function (Blueprint $table) {
            $table->dropForeign(['corretora_id']);
            $table->dropColumn('corretora_id');
        });
    }
}
