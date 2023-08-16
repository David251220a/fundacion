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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained();
            $table->foreignId('salario_pago_id')->constrained();
            // $table->date('fecha_inicio');
            // $table->date('fecha_fin')->nullable();
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
        Schema::dropIfExists('empleados');
    }
};
