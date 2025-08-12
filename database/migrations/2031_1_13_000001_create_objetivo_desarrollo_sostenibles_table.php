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
        Schema::create('objetivo_desarrollo_sostenible', function (Blueprint $table) {
            $table->id('idObjetivoDesarrolloSostenible');
            $table->unsignedBigInteger('idObjetivoEstrategico')->nullable();
            $table->foreign('idObjetivoEstrategico')->references('idObjetivoEstrategico')->on('objetivo_estrategico')->onDelete('cascade'); 
            $table->integer('numero');
            $table->string('nombre');
            $table->string('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivo_desarrollo_sostenible');
    }
};
