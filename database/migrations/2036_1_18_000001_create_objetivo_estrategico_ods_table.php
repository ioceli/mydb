<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivoEstrategicoOdsTable extends Migration
{
    public function up()
    {
        Schema::create('objetivo_estrategico_ods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idObjetivoEstrategico');
            $table->unsignedBigInteger('idObjetivoDesarrolloSostenible');

            $table->foreign('idObjetivoEstrategico')
                  ->references('idObjetivoEstrategico')
                  ->on('objetivo_estrategico')
                  ->onDelete('cascade');

            $table->foreign('idObjetivoDesarrolloSostenible')
                  ->references('idObjetivoDesarrolloSostenible')
                  ->on('objetivo_desarrollo_sostenible')
                  ->onDelete('cascade');

            $table->unique(['idObjetivoEstrategico', 'idObjetivoDesarrolloSostenible'], 'objetivo_ods_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('objetivo_estrategico_ods');
    }
}