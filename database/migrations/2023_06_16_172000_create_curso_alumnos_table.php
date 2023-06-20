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
        Schema::create('curso_alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_habilitado_id')->constrained();
            $table->foreignId('curso_a_estado_id')->constrained();
            $table->foreignId('alumno_id')->constrained();
            $table->decimal('total_pagar')->default(0);
            $table->decimal('monto_abonado')->default(0);
            $table->decimal('saldo')->default(0);
            $table->tinyInteger('aprobado')->default(0);
            $table->string('certificado', 250)->nullable();
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
        Schema::dropIfExists('curso_alumnos');
    }
};
