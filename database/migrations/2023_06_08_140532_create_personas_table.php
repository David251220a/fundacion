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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained();
            $table->foreignId('departamento_id')->constrained();
            $table->foreignId('ciudad_id')->constrained();
            $table->foreignId('barrio_id')->constrained();
            $table->foreignId('estado_civil_id')->constrained();
            $table->foreignId('partido_id')->constrained()->default(1);
            $table->string('documento', 20);
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->integer('sexo');
            $table->string('celular', 20)->nullable();
            $table->string('direccion', 200)->nullable();
            $table->date('fecha_nacimiento');
            $table->string('email', 200)->nullable();
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
        Schema::dropIfExists('personas');
    }
};
