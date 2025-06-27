<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entidad', function (Blueprint $table) {
            $table->id('idEntidad');
            $table->integer('codigo')->unique()->nullable();
            $table->string('subSector')->nullable();
            $table->string('nivelGobierno')->nullable();
            $table->string('estado')->nullable();
            $table->date('fechaCreacion')->nullable();
            $table->string('fechaActualizacion')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entidad');
    }
};
