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
        Schema::create('objetivo_estrategico', function (Blueprint $table) {
            $table->id('idObjetivoEstrategico');
            $table->unsignedBigInteger('idPlan')->nullable();
            $table->foreign('idPlan')->references('idPlan')->on('plan')->onDelete('cascade'); 
            $table->string('descripcion');
            $table->date('fechaRegistro');
            $table->enum('estado',['Activo','Inactivo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivo_estrategico');
    }
};
