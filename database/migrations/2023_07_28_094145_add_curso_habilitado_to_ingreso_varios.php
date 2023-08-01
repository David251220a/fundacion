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
        Schema::table('ingreso_varios', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_curso_id')->after('cuenta_padre')->default(0);
            $table->unsignedBigInteger('curso_id')->after('cuenta_padre')->default(0);
            $table->unsignedBigInteger('curso_habilitado_id')->after('cuenta_padre')->default(0);
            $table->unsignedBigInteger('curso_ingreso_id')->after('cuenta_padre')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingreso_varios', function (Blueprint $table) {
            $table->dropColumn('tipo_curso_id');
            $table->dropColumn('curso_id');
            $table->dropColumn('curso_habilitado_id');
            $table->dropColumn('curso_ingreso_id');
        });
    }
};
