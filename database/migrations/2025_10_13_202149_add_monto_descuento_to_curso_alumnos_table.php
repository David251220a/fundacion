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
        Schema::table('curso_alumnos', function (Blueprint $table) {
            $table->unsignedDecimal('total_descuento', 12, 0)->default(0);
            $table->unsignedInteger('porcentaje_aplicado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curso_alumnos', function (Blueprint $table) {
            $table->dropColumn(['total_descuento', 'porcentaje_aplicado']);
        });
    }
};
