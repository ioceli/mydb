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
        Schema::create('proyecto', function (Blueprint $table) {
            $table->id('idProyecto');
            $table->unsignedBigInteger('idEntidad');
            $table->foreign('idEntidad')->references('idEntidad')->on('entidad')->onDelete('cascade');
           $table->string('nombre');
            $table->enum('estado',['Activo','Inactivo']);
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto');
    }
};
