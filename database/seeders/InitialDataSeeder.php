<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

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

        // Si ya existen productos, evitar re-inserción innecesaria
        if (Schema::hasTable('productos') && DB::table('productos')->count() >= 19) {
            $this->command?->info('El catálogo de productos ya cuenta con los registros iniciales.');
            return;
        }

        $sql = File::get($sqlPath);

        // Desactivar temporalmente revisión de llaves foráneas
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        } catch (\Throwable $e) {
            // Ignorar si el driver no lo soporta
        }

        // Intentar ejecución directa por bloques o por sentencias individuales
        $statements = array_filter(
            array_map('trim', explode(";\n", $sql)),
            fn($stmt) => !empty($stmt) && !str_starts_with($stmt, '--')
        );

        $inserted = 0;
        foreach ($statements as $statement) {
            $cleaned = trim($statement);
            if (empty($cleaned)) {
                continue;
            }

            try {
                DB::unprepared($cleaned . ';');
                $inserted++;
            } catch (\Throwable $e) {
                // Loguear pero continuar con las siguientes sentencias para máxima resiliencia
            }
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        } catch (\Throwable $e) {
            // Ignorar
        }

        $this->command?->info("Seeder completado. Se procesaron $inserted sentencias iniciales.");
    }
}
