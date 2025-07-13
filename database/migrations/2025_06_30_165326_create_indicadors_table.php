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
        Schema::create('indicador', function (Blueprint $table) {
            $table->id('idIndicador');
            $table->unsignedBigInteger('idMetaEstrategica')->nullable();
            $table->foreign('idMetaEstrategica')->references('idMetaEstrategica')->on('meta_estrategica')->onDelete('cascade'); 
            $table->string('nombre');
            $table->string('descripcion');
            $table->date('fechaMedicion');
            $table->string('formula');
            $table->string('tipo');
            $table->string('unidadMedida');
            $table->decimal('valorActual');
            $table->decimal('valorBase');
            $table->decimal('valorMeta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador');
    }
};
