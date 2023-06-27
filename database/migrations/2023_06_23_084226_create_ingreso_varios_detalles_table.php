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
        Schema::create('ingreso_varios_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained();
            $table->foreignId('ingreso_vario_id')->constrained();
            $table->foreignId('ingreso_concepto_id')->constrained();
            $table->string('descripcion', 200)->nullable();
            $table->decimal('precio_unitario', 12, 0)->default(0);
            $table->integer('cantidad')->default(0);
            $table->decimal("total_pagar", 12, 0)->default(0);
            $table->decimal('monto_pagado', 12, 0)->default(0);
            $table->decimal('saldo', 12, 0)->default(0);
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
        Schema::dropIfExists('ingreso_varios_detalles');
    }
};
