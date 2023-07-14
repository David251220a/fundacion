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
        Schema::table('curso_alumnos', function (Blueprint $table) {
            $table->decimal('certificado_monto', 12, 0)->after('saldo')->default(0);
            $table->decimal('certificado_pagado', 12, 0)->after('certificado_monto')->default(0);
            $table->decimal('certificado_saldo', 12, 0)->after('certificado_pagado')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curso_alumnos', function (Blueprint $table) {
            $table->dropColumn('certificado_monto');
            $table->dropColumn('certificado_pagado');
            $table->dropColumn('certificado_saldo');
        });
    }
};
