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
        Schema::create('persona', function (Blueprint $table) {
            $table->id('idPersona');
            $table->unsignedBigInteger('idEntidad');
            $table->foreign('idEntidad')->references('idEntidad')->on('entidad')->onDelete('cascade');
            $table->string('cedula',10)->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->enum('rol',['Administrador del Sistema',
                'Técnico de Planificación',
                'Revisor Institucional',
                'Autoridad Validante',
                'Usuario Externo',
                'Auditor',
                'Desarrollador']);
            $table->enum('estado',['Activo','Inactivo']);
            $table->string('correo')->unique();
            $table->enum('genero',['Masculino','Femenino','Otro']);
            $table->string('telefono',10);
            $table->string('contraseña');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
