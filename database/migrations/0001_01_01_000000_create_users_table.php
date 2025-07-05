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
        Schema::create('users', function (Blueprint $table) {
            $table->id('idUser');
            $table->string('cedula',10)->unique();
            $table->string('name');
            $table->string('apellidos');
            $table->enum('rol',['Administrador del Sistema',
                'Técnico de Planificación',
                'Revisor Institucional',
                'Autoridad Validante',
                'Usuario Externo',
                'Auditor',
                'Desarrollador']);
            $table->enum('estado',['Activo','Inactivo']);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('genero',['Masculino','Femenino','Otro']);
            $table->string('telefono',10);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
