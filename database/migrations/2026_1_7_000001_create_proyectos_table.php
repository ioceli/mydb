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
            $table->string('cup')->unique();
            $table->string('tipo_dictamen');
            $table->string('nombre');
            $table->string('accion')->nullable();
            $table->string('objeto')->nullable();
            $table->string('estado_revision')->default('pendiente');
            $table->string('estado_autoridad')->default('pendiente');   
            $table->timestamps();
            $table->string('plazo_ejecucion');
            $table->decimal('monto_total', 14, 2);
            $table->text('diagnostico')->nullable();
            $table->text('problema')->nullable();
            $table->decimal('longitud', 10, 8)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            
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