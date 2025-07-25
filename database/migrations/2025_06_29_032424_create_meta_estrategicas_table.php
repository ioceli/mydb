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
        Schema::create('meta_estrategica', function (Blueprint $table) {
            $table->id('idMetaEstrategica');
            $table->unsignedBigInteger('idPlan')->nullable();
            $table->foreign('idPlan')->references('idPlan')->on('plan')->onDelete('cascade'); 
            $table->string('nombre');
            $table->string('descripcion');
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->string('formulaIndicador');
            $table->decimal('metaEsperada');
            $table->decimal('progresoActual');
            $table->string('tipoIndicador');
            $table->string('unidadMedida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_estrategica');
    }
};
