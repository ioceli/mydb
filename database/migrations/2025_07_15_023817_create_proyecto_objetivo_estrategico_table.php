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
        Schema::create('proyecto_objetivo_estrategico', function (Blueprint $table) {
           $table->unsignedBigInteger('idProyecto');
            $table->unsignedBigInteger('idObjetivoEstrategico');

            $table->foreign('idProyecto')->references('idProyecto')->on('proyecto')->onDelete('cascade');
            $table->foreign('idObjetivoEstrategico')->references('idObjetivoEstrategico')->on('objetivo_estrategico')->onDelete('cascade');

            $table->primary(['idProyecto', 'idObjetivoEstrategico']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_objetivo_estrategico');
    }
};
