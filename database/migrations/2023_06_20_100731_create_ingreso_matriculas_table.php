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
        Schema::create('ingreso_matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained();
            $table->foreignId('forma_pago_id')->constrained();
            $table->date('fecha_ingreso');
            $table->integer('año')->default(0);
            $table->tinyInteger('mes')->default(0);
            $table->integer('numero_recibo');
            $table->string('sucursal', 3)->default('000');
            $table->string('general', 3)->default('000');
            $table->integer('factura_numero')->default(0);
            $table->decimal('total_pagado')->default(0);
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
        Schema::dropIfExists('ingreso_matriculas');
    }
};
