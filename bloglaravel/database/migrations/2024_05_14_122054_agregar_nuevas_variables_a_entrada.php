<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('entradas', function (Blueprint $table) {
            $table->time('hora')->nullable();
            $table->integer('prioridad')->default(0);
            $table->string('lugar')->nullable();
            $table->string('estado')->nullable();
        });
    }

    public function down()
    {
        Schema::table('entradas', function (Blueprint $table) {
            $table->dropColumn('hora');
            $table->dropColumn('prioridad');
            $table->dropColumn('lugar');
            $table->dropColumn('estado');
        });
    }
};
