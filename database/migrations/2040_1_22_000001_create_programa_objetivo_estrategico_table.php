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
        Schema::create('programa_objetivo_estrategico', function (Blueprint $table) {
           $table->unsignedBigInteger('idPrograma');
            $table->unsignedBigInteger('idObjetivoEstrategico');

            $table->foreign('idPrograma')->references('idPrograma')->on('programa')->onDelete('cascade');
            $table->foreign('idObjetivoEstrategico')->references('idObjetivoEstrategico')->on('objetivo_estrategico')->onDelete('cascade');

            $table->primary(['idPrograma', 'idObjetivoEstrategico']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_objetivo_estrategico');
    }
};
