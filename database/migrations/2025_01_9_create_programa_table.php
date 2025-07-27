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
        Schema::create('programa', function (Blueprint $table) {
            $table->id('idPrograma');
            $table->unsignedBigInteger('idEntidad');
            $table->string('cup')->unique();
            $table->string('tipo_dictamen');
            $table->string('nombre');
            $table->string('estado_revision')->default('pendiente');
            $table->string('estado_autoridad')->default('pendiente');   
            $table->timestamps();
            $table->string('plazo_ejecucion');
            $table->decimal('monto_total', 14, 2);
            $table->text('diagnostico')->nullable();
            $table->text('marco_logico')->nullable();
            $table->text('analisis_integral')->nullable();
            $table->text('financiamiento')->nullable();
            $table->text('estrategia_ejecucion')->nullable();
            $table->text('seguimiento_evaluacion')->nullable();
            $table->text('anexos')->nullable();
            $table->foreign('idEntidad')->references('idEntidad')->on('entidad')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa');
    }
};
