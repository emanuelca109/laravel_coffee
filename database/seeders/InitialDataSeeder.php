<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = database_path('seeders/initial_data.sql');
        if (!File::exists($sqlPath)) {
            $this->command?->warn("No se encontró el archivo $sqlPath");
            return;
        }

        // Si ya existen al menos 19 productos, no necesitamos volver a insertar
        if (Schema::hasTable('productos') && DB::table('productos')->count() >= 19) {
            $this->command?->info('El catálogo de productos ya cuenta con los registros iniciales.');
            return;
        }

        $sql = File::get($sqlPath);

        // Desactivar temporalmente revisión de llaves foráneas
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        } catch (\Throwable $e) {
            // Ignorar si no está soportado
        }

        // Dividir por punto y coma seguido de fin de línea (\r\n o \n)
        $lines = preg_split('/;\s*[\r\n]+/', $sql);

        $inserted = 0;
        foreach ($lines as $statement) {
            $cleaned = trim($statement);
            // Eliminar líneas de comentarios SQL (-- ...)
            $cleaned = preg_replace('/^--.*$/m', '', $cleaned);
            $cleaned = trim($cleaned);

            if (empty($cleaned)) {
                continue;
            }

            try {
                DB::statement($cleaned);
                $inserted++;
            } catch (\Throwable $e) {
                Log::warning("InitialDataSeeder: " . $e->getMessage() . " | SQL: " . substr($cleaned, 0, 80));
            }
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        } catch (\Throwable $e) {
            // Ignorar
        }

        $this->command?->info("Seeder completado. Se ejecutaron $inserted sentencias iniciales.");
    }
}
