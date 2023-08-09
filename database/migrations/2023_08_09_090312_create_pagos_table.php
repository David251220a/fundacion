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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_tipo_id')->constrained();
            $table->date('fecha');
            $table->integer('mes')->default(0);
            $table->integer('anio')->default(0);
            $table->decimal('importe', 12, 0)->default(0);
            $table->integer('procesado')->default(0);
            $table->string('sucursal', 4)->default('0000');
            $table->string('general', 4)->default('0000');
            $table->integer('factura_numero')->default(0);
            $table->integer('numero_recibo')->default(0);
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
        Schema::dropIfExists('pagos');
    }
};
