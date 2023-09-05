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
        Schema::create('salario_cierres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forma_pago_id')->constrained();
            $table->foreignId('salario_pago_id')->constrained();
            $table->foreignId('pago_tipo_id')->constrained();
            $table->foreignId('pago_id')->constrained();
            $table->date('fecha_cierre');
            $table->decimal('total_salario', 12, 0)->default(0);
            $table->decimal('total_descuento', 12, 0)->default(0);
            $table->decimal('total_neto', 12, 0)->default(0);
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
        Schema::dropIfExists('salario_cierres');
    }
};
