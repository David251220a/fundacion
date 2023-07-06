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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained();
            $table->foreignId('curso_modulo_id')->constrained();
            $table->foreignId('tipo_curso_id')->constrained();
            $table->foreignId('alumno_id')->constrained();
            $table->foreignId('curso_a_estado_id')->constrained();
            $table->date('fecha_agenda')->nullable();
            $table->string('observacion', 200)->nullable();
            $table->tinyInteger('contacto', 0)->default(0);
            $table->date('fecha_contacto')->nullable();
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
        Schema::dropIfExists('agendas');
    }
};
