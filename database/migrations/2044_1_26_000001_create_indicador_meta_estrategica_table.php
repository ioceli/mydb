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
        Schema::create('indicador_meta_estrategica', function (Blueprint $table) {
          $table->unsignedBigInteger('idMetaEstrategica')->nullable();
            $table->foreign('idMetaEstrategica')->references('idMetaEstrategica')->on('meta_estrategica')->onDelete('cascade');
          $table->unsignedBigInteger('idIndicador')->nullable();
            $table->foreign('idIndicador')->references('idIndicador')->on('indicador')->onDelete('cascade');
       
            $table->primary(['idMetaEstrategica', 'idIndicador']);});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_meta_estrategica');
    }
};
