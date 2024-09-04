<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorretoraIdToComissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comissoes', function (Blueprint $table) {
            $table->unsignedBigInteger('corretora_id')->after('id');
            $table->foreign('corretora_id')->references('id')->on('corretoras');
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
            $table->dropForeign(['corretora_id']);

            $table->dropColumn('corretora_id');
        });
    }
}
