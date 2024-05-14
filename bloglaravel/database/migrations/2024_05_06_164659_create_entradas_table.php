<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();

            $table->string("titulo");
            $table->string("imagen");
            $table->string("descripcion");
            $table->date("fecha");

            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("categoria_id");

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("categoria_id")->references("id")->on("categorias")->onDelete("cascade");;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
