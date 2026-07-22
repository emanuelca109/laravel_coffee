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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_direccion');
            $table->string('nombre_completo');
            $table->string('telefono');
            $table->string('direccion');
            $table->string('departamento');
            $table->string('municipio');
            $table->string('codigo_postal')->nullable();
            $table->text('referencias')->nullable();

            $table->foreignId('cliente_id')
                  ->constrained('users');

            $table->timestamps();
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->foreign('direccion_id')->references('id')->on('direcciones')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
