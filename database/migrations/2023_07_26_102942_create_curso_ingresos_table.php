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
        Schema::create('curso_ingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_habilitado_id')->constrained();
            $table->foreignId('ingreso_concepto_id')->constrained();
            $table->date('fecha');
            $table->string('descripcion', 200)->nullable();
            $table->integer('utilizado')->default(0);
            $table->decimal('precio', 12, 0)->default(0);
            $table->integer('clase')->default(0);
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
        Schema::dropIfExists('curso_ingresos');
    }
};
