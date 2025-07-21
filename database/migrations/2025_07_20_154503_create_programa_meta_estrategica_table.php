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
        Schema::create('programa_meta_estrategica', function (Blueprint $table) {
           $table->unsignedBigInteger('idPrograma');
            $table->unsignedBigInteger('idMetaEstrategica');

            $table->foreign('idPrograma')->references('idPrograma')->on('programa')->onDelete('cascade');
            $table->foreign('idMetaEstrategica')->references('idMetaEstrategica')->on('meta_estrategica')->onDelete('cascade');

            $table->primary(['idPrograma', 'idMetaEstrategica']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_meta_estrategica');
    }
};
