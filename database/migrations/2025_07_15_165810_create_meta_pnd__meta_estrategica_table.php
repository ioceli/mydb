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
        Schema::create('meta_pnd_meta_estrategica', function (Blueprint $table) {
           $table->unsignedBigInteger('idMetaPlanNacional');
            $table->unsignedBigInteger('idMetaEstrategica');

            $table->foreign('idMetaPlanNacional')->references('idMetaPlanNacional')->on('meta_plan_nacional')->onDelete('cascade');
            $table->foreign('idMetaEstrategica')->references('idMetaEstrategica')->on('meta_estrategica')->onDelete('cascade');

            $table->primary(['idMetaPlanNacional', 'idMetaEstrategica']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_pnd_meta_estrategica');
    }
};
