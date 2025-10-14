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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 250);
            $table->integer('porcentaje')->default(0);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->tinyInteger('lunes')->default(0);
            $table->tinyInteger('martes')->default(0);
            $table->tinyInteger('miercoles')->default(0);
            $table->tinyInteger('jueves')->default(0);
            $table->tinyInteger('viernes')->default(0);
            $table->tinyInteger('sabado')->default(0);
            $table->tinyInteger('domingo')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->tinyInteger('estado_id')->default(1);
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
        Schema::dropIfExists('promos');
    }
};
