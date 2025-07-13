<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjetivoEstrategicoOpndTable extends Migration
{
    public function up()
    {
        Schema::create('objetivo_estrategico_opnd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idObjetivoEstrategico');
            $table->unsignedBigInteger('idObjetivoPlanNacional');

            $table->foreign('idObjetivoEstrategico')
                  ->references('idObjetivoEstrategico')
                  ->on('objetivo_estrategico')
                  ->onDelete('cascade');

            $table->foreign('idObjetivoPlanNacional')
                  ->references('idObjetivoPlanNacional')
                  ->on('objetivo_plan_nacional')
                  ->onDelete('cascade');

            $table->unique(['idObjetivoEstrategico', 'idObjetivoPlanNacional'], 'objetivo_opnd_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('objetivo_estrategico_opnd');
    }
}