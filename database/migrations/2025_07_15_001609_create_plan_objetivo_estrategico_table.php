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
        Schema::create('plan_objetivo_estrategico', function (Blueprint $table) {
           $table->unsignedBigInteger('idPlan');
            $table->unsignedBigInteger('idObjetivoEstrategico');

            $table->foreign('idPlan')->references('idPlan')->on('plan')->onDelete('cascade');
            $table->foreign('idObjetivoEstrategico')->references('idObjetivoEstrategico')->on('objetivo_estrategico')->onDelete('cascade');

            $table->primary(['idPlan', 'idObjetivoEstrategico']);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_objetivo_estrategico');
    }
};
