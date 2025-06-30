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
        Schema::create('objetivo_plan_nacional', function (Blueprint $table) {
            $table->id('idObjetivoPlanNacional');
            $table->timestamps();
            $table->integer('codigo')->unique();
            $table->string('nombre');
            $table->string('descripcion');
           $table->enum('ejePnd',['EJE SOCIAL','EJE DESARROLLO ECONOMICO','EJE INFRAESTRUCTURA ENERCIA MEDIO AMBIENTE','EJE INSTITUCIONAL','EJE GESTION RIESGOS']);
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivo_plan_nacional');
    }
};
