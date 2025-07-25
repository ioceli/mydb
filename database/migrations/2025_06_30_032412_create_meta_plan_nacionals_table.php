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
        Schema::create('meta_plan_nacional', function (Blueprint $table) {
            $table->id('idMetaPlanNacional');
            $table->unsignedBigInteger('idMetaEstrategica')->nullable();
            $table->foreign('idMetaEstrategica')->references('idMetaEstrategica')->on('meta_estrategica')->onDelete('cascade'); 
            $table->string('nombre');
            $table->string('descripcion');
            $table->decimal('porcentajeAlineacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_plan_nacional');
    }
};
