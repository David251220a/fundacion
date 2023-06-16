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
        Schema::create('persona_familias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->foreignId('tipo_familia_id')->constrained();
            $table->foreignId('partido_id')->constrained()->default(1);
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
        Schema::dropIfExists('persona_familias');
    }
};
