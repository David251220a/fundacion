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
        Schema::table('curso_habilitados', function (Blueprint $table) {
            $table->decimal('precio_certificado', 12, 0)->after('precio')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curso_habilitados', function (Blueprint $table) {
            $table->dropColumn('precio_certificado');
        });
    }
};
