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
        Schema::create('ingreso_matricula_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_habilitado_id')->constrained();
            $table->foreignId('alumno_id')->constrained();
            $table->foreignId('ingreso_matricula_id')->constrained();
            $table->decimal('monto_total')->default(0);
            $table->decimal('monto_pagado')->default(0);
            $table->decimal('saldo')->default(0);
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
        Schema::dropIfExists('ingreso_matricula_detalles');
    }
};
