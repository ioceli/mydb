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
        Schema::create('tarea_programa', function (Blueprint $table) {
            $table->id('idTarea');
            $table->unsignedBigInteger('idActividad');
            $table->foreign('idActividad')->references('idActividad')->on('actividad_programa')->onDelete('cascade');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->decimal('monto', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_programa');
    }
};
