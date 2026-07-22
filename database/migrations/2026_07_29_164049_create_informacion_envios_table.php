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
        Schema::create('informacion_envios', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_envio');
            $table->date('fecha_entrega')->nullable();
            $table->string('ciudad');
            $table->string('direccion');
            $table->string('transportadora');
            $table->string('estado');

            $table->foreignId('pedido_id')
                  ->constrained('pedidos')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_envios');
    }
};
