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
        Schema::create('plan_meta_estrategica', function (Blueprint $table) {
           $table->unsignedBigInteger('idPlan');
            $table->unsignedBigInteger('idMetaEstrategica');

            $table->foreign('idPlan')->references('idPlan')->on('plan')->onDelete('cascade');
            $table->foreign('idMetaEstrategica')->references('idMetaEstrategica')->on('meta_estrategica')->onDelete('cascade');

            $table->primary(['idPlan', 'idMetaEstrategica']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_estrategica');
    }
};
