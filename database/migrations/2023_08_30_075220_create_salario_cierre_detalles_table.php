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
        Schema::create('salario_cierre_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salario_cierre_id')->constrained();
            $table->foreignId('empleado_id')->constrained();
            $table->foreignId('salario_concepto_id')->constrained();
            $table->decimal('importe', 12, 0)->default(0);
            $table->integer('tipo')->default(1);
            $table->foreignId('estado_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('modif_user_id');
            $table->foreign('modif_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('salario_cierre_detalles');
    }
};
