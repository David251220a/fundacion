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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150)->nullable();
            $table->text('contenido')->nullable();
            $table->string('feed_facebook')->nullable();
            $table->string('feed_instagram')->nullable();
            $table->tinyInteger('portada', false, false);
            $table->string('slug');
            $table->foreignId('tag_id')->constrained();
            $table->foreignId('estado_id')->constrained()->default(1);
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
        Schema::dropIfExists('noticias');
    }
};
