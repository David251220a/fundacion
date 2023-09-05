<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingreso_matriculas', function (Blueprint $table) {
            $table->bigInteger('cierre_caja_id')->after('estado_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingreso_matriculas', function (Blueprint $table) {
            $table->dropColumn('cierre_caja_id');
        });
    }
};
