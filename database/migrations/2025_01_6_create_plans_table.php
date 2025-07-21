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
        Schema::create('plan', function (Blueprint $table) {
            $table->id('idPlan');
            $table->unsignedBigInteger('idEntidad');
            $table->foreign('idEntidad')->references('idEntidad')->on('entidad')->onDelete('cascade');
            $table->string('nombre');
            $table->string('estado_revision')->default('pendiente');
            $table->string('estado_autoridad')->default('pendiente');
            $table->timestamps();
            });  
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan');
    }
};
