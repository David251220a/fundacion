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
        Schema::create('curso_habilitados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_curso_id')->constrained();
            $table->foreignId('curso_id')->constrained();
            $table->foreignId('periodo_id')->constrained();
            $table->foreignId('instructor_id')->constrained();
            $table->string('descripcion', 250)->nullable();
            $table->text('observacion')->nullable();
            $table->date('periodo_desde');
            $table->date('periodo_hasta')->nullable();
            $table->integer('duracion')->nullable();
            $table->decimal('precio', 12, 0);
            $table->string('portada', 250);
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->tinyInteger('lunes');
            $table->tinyInteger('martes');
            $table->tinyInteger('miercoles');
            $table->tinyInteger('jueves');
            $table->tinyInteger('viernes');
            $table->tinyInteger('sabado');
            $table->tinyInteger('domingo');
            $table->tinyInteger('concluido')->default(0);
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
        Schema::dropIfExists('curso_habilitados');
    }
};
