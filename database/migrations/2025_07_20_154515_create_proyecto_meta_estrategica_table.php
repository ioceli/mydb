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
        Schema::create('proyecto_meta_estrategica', function (Blueprint $table) {
           $table->unsignedBigInteger('idProyecto');
            $table->unsignedBigInteger('idMetaEstrategica');

            $table->foreign('idProyecto')->references('idProyecto')->on('proyecto')->onDelete('cascade');
            $table->foreign('idMetaEstrategica')->references('idMetaEstrategica')->on('meta_estrategica')->onDelete('cascade');

            $table->primary(['idProyecto', 'idMetaEstrategica']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_meta_estrategica');
    }
};
