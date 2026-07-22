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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto',10,2);
            $table->string('factura');
            $table->string('metodo_pago');
            $table->date('fecha_pago');
            $table->string('estado_pago');

            $table->foreignId('pedido_id')
                  ->nullable()
                  ->constrained('pedidos')
                  ->nullOnDelete();

            $table->foreignId('venta_id')
                  ->nullable()
                  ->constrained('ventas')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
