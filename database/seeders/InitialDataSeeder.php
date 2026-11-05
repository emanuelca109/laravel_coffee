<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialDataSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        } catch (\Throwable $e) {}

        // Tabla roles (2 registros)
        if (Schema::hasTable('roles')) {
            $data = array (
  0 => 
  array (
    'id' => '1',
    'nombre' => 'Admin',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
  1 => 
  array (
    'id' => '2',
    'nombre' => 'Cliente',
    'created_at' => NULL,
    'updated_at' => NULL,
  ),
);
            foreach ($data as $row) {
                try {
                    DB::table('roles')->updateOrInsert(['id' => $row['id']], $row);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Error insertando en roles id={$row['id']}: " . $e->getMessage());
                }
            }
            $this->command?->info('Tabla roles poblada con éxito.');
        }

        // Tabla users (6 registros)
        if (Schema::hasTable('users')) {
            $data = array (
  0 => 
  array (
    'id' => '1',
    'role_id' => '1',
    'name' => 'Emanuel',
    'email' => 'ema@gmail.com',
    'documento' => NULL,
    'telefono' => NULL,
    'email_verified_at' => NULL,
    'password' => '$2y$12$xVzTOd2tyaCPPLDzR4bi7Ox3v7FnsR.9ykB9demtcujmLQYCK9PuC',
    'estado' => 'Activo',
    'remember_token' => NULL,
    'created_at' => '2026-08-05 15:52:08',
    'updated_at' => '2026-09-24 18:35:48',
    'carrito' => '{\\"17\\": {\\"cantidad\\": \\"3\\"}}',
  ),
  1 => 
  array (
    'id' => '2',
    'role_id' => '2',
    'name' => 'Jhor',
    'email' => 'jhor@gmail.com',
    'documento' => '10202222',
    'telefono' => '3147602123',
    'email_verified_at' => NULL,
    'password' => '$2y$12$ge4t0nMb/Z.sc73Xl70vZu.LHJ/fvHHZV7AqSfg.yDJV3QMZCEH/m',
    'estado' => 'Activo',
    'remember_token' => NULL,
    'created_at' => '2026-08-10 00:55:25',
    'updated_at' => '2026-11-05 00:30:48',
    'carrito' => '{\\"16\\": {\\"cantidad\\": 10}, \\"17\\": {\\"cantidad\\": 14}, \\"18\\": {\\"cantidad\\": 1}, \\"19\\": {\\"cantidad\\": 1}}',
  ),
  2 => 
  array (
    'id' => '3',
    'role_id' => '2',
    'name' => 'Justo',
    'email' => 'justo@gmail.com',
    'documento' => '1023456789',
    'telefono' => NULL,
    'email_verified_at' => NULL,
    'password' => '$2y$12$QELwOw9vxXhAwx/nxIBDNObL620G6eRfz3xDDSUagoMpCo9GpyE4C',
    'estado' => 'Activo',
    'remember_token' => NULL,
    'created_at' => '2026-08-19 13:40:12',
    'updated_at' => '2026-09-15 03:34:41',
    'carrito' => '{\\"17\\": {\\"cantidad\\": 1}}',
  ),
  3 => 
  array (
    'id' => '4',
    'role_id' => '2',
    'name' => 'Miguel',
    'email' => 'miguel@gmail.com',
    'documento' => NULL,
    'telefono' => NULL,
    'email_verified_at' => NULL,
    'password' => '$2y$12$YN7haUUfIuu03rmZPauLVuEqVJq8jZ2rKfRDxvl4muf7nDSzGeLFW',
    'estado' => 'Activo',
    'remember_token' => NULL,
    'created_at' => '2026-08-26 12:49:21',
    'updated_at' => '2026-08-26 12:49:21',
    'carrito' => NULL,
  ),
  4 => 
  array (
    'id' => '5',
    'role_id' => '2',
    'name' => 'Miguel',
    'email' => 'miguelito@gmail.com',
    'documento' => '1222232223',
    'telefono' => '324345354',
    'email_verified_at' => NULL,
    'password' => '$2y$12$ulPIyAXgv6c./yIBcNU8SOVR/c/KerJ72opjdEjMcRdMNhrrTq86m',
    'estado' => 'Activo',
    'remember_token' => NULL,
    'created_at' => '2026-08-26 12:49:44',
    'updated_at' => '2026-08-26 15:07:34',
    'carrito' => '{\\"12\\": {\\"cantidad\\": 1}, \\"14\\": {\\"cantidad\\": 1}, \\"15\\": {\\"cantidad\\": 1}, \\"16\\": {\\"cantidad\\": 1}, \\"17\\": {\\"cantidad\\": 1}}',
  ),
  5 => 
  array (
    'id' => '6',
    'role_id' => '2',
    'name' => 'Patron',
    'email' => 'patron@gmail.com',
    'documento' => NULL,
    'telefono' => NULL,
    'email_verified_at' => NULL,
    'password' => '$2y$12$reroEDVQjz7oz6kCZ41CAOnZKE58/Wg67qCs.ONa96TvGv.EEBn6q',
    'estado' => 'Activo',
    'remember_token' => NULL,
    'created_at' => '2026-08-30 17:28:57',
    'updated_at' => '2026-08-30 17:29:17',
    'carrito' => '[]',
  ),
);
            foreach ($data as $row) {
                try {
                    DB::table('users')->updateOrInsert(['id' => $row['id']], $row);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Error insertando en users id={$row['id']}: " . $e->getMessage());
                }
            }
            $this->command?->info('Tabla users poblada con éxito.');
        }

        // Tabla categorias (8 registros)
        if (Schema::hasTable('categorias')) {
            $data = array (
  0 => 
  array (
    'id' => '1',
    'nombre' => 'insectisidas',
    'descripcion' => 'productos fitosanitarios diseñados para prevenir, repeler o eliminar plagas que afectan los cultivos',
    'estado' => 'Activo',
    'created_at' => '2026-08-05 15:53:15',
    'updated_at' => '2026-08-19 15:24:32',
  ),
  1 => 
  array (
    'id' => '3',
    'nombre' => 'Fungicida',
    'descripcion' => 'dsfds',
    'estado' => 'Activo',
    'created_at' => '2026-08-05 18:47:55',
    'updated_at' => '2026-08-05 18:47:55',
  ),
  2 => 
  array (
    'id' => '4',
    'nombre' => 'Quiminsec',
    'descripcion' => 'control total de plaga',
    'estado' => 'Activo',
    'created_at' => '2026-08-05 18:48:32',
    'updated_at' => '2026-08-25 23:57:55',
  ),
  3 => 
  array (
    'id' => '6',
    'nombre' => 'Herbicida',
    'descripcion' => 'encargado para controlar o eliminar plantas no deseadas',
    'estado' => 'Activo',
    'created_at' => '2026-08-25 20:15:32',
    'updated_at' => '2026-08-25 20:15:32',
  ),
  4 => 
  array (
    'id' => '7',
    'nombre' => 'Fertilizantes',
    'descripcion' => 'Los fertilizantes proporcionan los nutrientes esenciales, como nitrógeno, fósforo y potasio',
    'estado' => 'Activo',
    'created_at' => '2026-08-25 20:16:01',
    'updated_at' => '2026-08-25 20:16:13',
  ),
  5 => 
  array (
    'id' => '8',
    'nombre' => 'Abonos',
    'descripcion' => 'mejora',
    'estado' => 'Activo',
    'created_at' => '2026-08-25 20:16:32',
    'updated_at' => '2026-08-25 20:16:32',
  ),
  6 => 
  array (
    'id' => '9',
    'nombre' => 'coffee spam',
    'descripcion' => 'chapolas',
    'estado' => 'Inactivo',
    'created_at' => '2026-08-25 20:22:09',
    'updated_at' => '2026-08-25 23:58:41',
  ),
  7 => 
  array (
    'id' => '10',
    'nombre' => 'cafeeee',
    'descripcion' => 'cccc',
    'estado' => 'Activo',
    'created_at' => '2026-09-02 18:06:59',
    'updated_at' => '2026-09-02 18:06:59',
  ),
);
            foreach ($data as $row) {
                try {
                    DB::table('categorias')->updateOrInsert(['id' => $row['id']], $row);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Error insertando en categorias id={$row['id']}: " . $e->getMessage());
                }
            }
            $this->command?->info('Tabla categorias poblada con éxito.');
        }

        // Tabla proveedores (5 registros)
        if (Schema::hasTable('proveedores')) {
            $data = array (
  0 => 
  array (
    'id' => '1',
    'nombre_empresa' => 'Proveedor Localeeeee',
    'nombre_proveedor' => 'Jose Perez',
    'telefono' => '22222222',
    'correo' => 'proveedor@local.com',
    'direccion' => 'calle 2 -4',
    'estado' => 'Activo',
    'created_at' => '2026-08-06 00:50:05',
    'updated_at' => '2026-09-02 13:33:08',
  ),
  1 => 
  array (
    'id' => '2',
    'nombre_empresa' => 'Coffeeland',
    'nombre_proveedor' => 'Carlos Rodriguez',
    'telefono' => '3212555564',
    'correo' => 'carlos@gmail.com',
    'direccion' => 'calle5-8',
    'estado' => 'Activo',
    'created_at' => '2026-08-06 01:11:28',
    'updated_at' => '2026-08-06 01:11:28',
  ),
  2 => 
  array (
    'id' => '3',
    'nombre_empresa' => 'Cafe del valle',
    'nombre_proveedor' => 'Benjamin Otalora',
    'telefono' => '3186382922',
    'correo' => 'benja@gmail.com',
    'direccion' => 'calle 3- 5',
    'estado' => 'Activo',
    'created_at' => '2026-08-06 01:23:11',
    'updated_at' => '2026-08-06 01:23:11',
  ),
  3 => 
  array (
    'id' => '4',
    'nombre_empresa' => 'Proveedor Local',
    'nombre_proveedor' => 'jefe',
    'telefono' => '2343333332',
    'correo' => 'ema@correo.com',
    'direccion' => 'calle 2 -4',
    'estado' => 'Activo',
    'created_at' => '2026-08-06 02:27:28',
    'updated_at' => '2026-08-06 02:27:42',
  ),
  4 => 
  array (
    'id' => '7',
    'nombre_empresa' => 'Proveedor 2.0',
    'nombre_proveedor' => 'Pepe Garcia',
    'telefono' => '325262722',
    'correo' => 'prove@gmail.com',
    'direccion' => 'calle 2 -12',
    'estado' => 'Activo',
    'created_at' => '2026-09-24 17:21:59',
    'updated_at' => '2026-09-24 17:21:59',
  ),
);
            foreach ($data as $row) {
                try {
                    DB::table('proveedores')->updateOrInsert(['id' => $row['id']], $row);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Error insertando en proveedores id={$row['id']}: " . $e->getMessage());
                }
            }
            $this->command?->info('Tabla proveedores poblada con éxito.');
        }

        // Tabla productos (19 registros)
        if (Schema::hasTable('productos')) {
            $data = array (
  0 => 
  array (
    'id' => '2',
    'nombre' => 'herbicida x 7 L',
    'descripcion' => 'preparada para las hierbas que no aportan nada',
    'precio_venta' => '20000.00',
    'precio_compra' => '5000.00',
    'stock_actual' => '25',
    'stock_minimo' => '4',
    'estado' => 'Activo',
    'categoria_id' => '4',
    'proveedor_id' => '3',
    'created_at' => '2026-08-09 03:10:58',
    'updated_at' => '2026-08-26 00:41:21',
  ),
  1 => 
  array (
    'id' => '3',
    'nombre' => 'insectisidas',
    'descripcion' => 'rewwwwwwwwwwwwrefffffffffffff  dffffffdddddddddddddddddddddddddddddddddfdddd',
    'precio_venta' => '30000.00',
    'precio_compra' => '25000.00',
    'stock_actual' => '10',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '1',
    'proveedor_id' => '3',
    'created_at' => '2026-08-09 03:16:30',
    'updated_at' => '2026-08-26 00:34:46',
  ),
  2 => 
  array (
    'id' => '4',
    'nombre' => 'fungicid 2020',
    'descripcion' => 'Actúan formando una barrera protectora sobre la superficie de la planta. No penetran el tejido y son ideales para prevenir la germinación de esporas antes de que causen daño.',
    'precio_venta' => '30000.00',
    'precio_compra' => '10000.00',
    'stock_actual' => '10',
    'stock_minimo' => '3',
    'estado' => 'Activo',
    'categoria_id' => '3',
    'proveedor_id' => '1',
    'created_at' => '2026-08-25 20:34:01',
    'updated_at' => '2026-08-25 20:34:01',
  ),
  3 => 
  array (
    'id' => '5',
    'nombre' => 'Abono 31',
    'descripcion' => 'Actúan formando una barrera protectora sobre la superficie de la planta. No penetran el tejido y son ideales para prevenir la germinación de esporas antes de que causen daño.',
    'precio_venta' => '80000.00',
    'precio_compra' => '40000.00',
    'stock_actual' => '21',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '8',
    'proveedor_id' => '4',
    'created_at' => '2026-08-25 20:38:02',
    'updated_at' => '2026-08-26 18:25:19',
  ),
  4 => 
  array (
    'id' => '6',
    'nombre' => 'Abono Mejor',
    'descripcion' => 'ustancias químicas o biológicas diseñadas para prevenir, detener o eliminar el crecimiento de hongos y esporas que atacan y enferman los cultivos. Son esenciales para evitar pérdidas económicas, proteger el follaje, las raíces y mejorar la calidad de la cosecha',
    'precio_venta' => '25000.00',
    'precio_compra' => '8000.00',
    'stock_actual' => '12',
    'stock_minimo' => '4',
    'estado' => 'Activo',
    'categoria_id' => '8',
    'proveedor_id' => '2',
    'created_at' => '2026-08-25 23:56:35',
    'updated_at' => '2026-08-25 23:56:35',
  ),
  5 => 
  array (
    'id' => '7',
    'nombre' => 'fertilizante 8213',
    'descripcion' => 'ustancias químicas o biológicas diseñadas para prevenir, detener o eliminar el crecimiento de hongos y esporas que atacan y enferman los cultivos. Son esenciales para evitar pérdidas económicas, proteger el follaje, las raíces y mejorar la calidad de la cosecha',
    'precio_venta' => '40000.00',
    'precio_compra' => '15000.00',
    'stock_actual' => '20',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '7',
    'proveedor_id' => '2',
    'created_at' => '2026-08-26 00:02:43',
    'updated_at' => '2026-08-26 00:02:43',
  ),
  6 => 
  array (
    'id' => '8',
    'nombre' => 'fertilizante wi 283',
    'descripcion' => 'Herbicida selectivo a gramíneas y sistémico; recomendado para controlar malezas de hoja ancha, leñosas, semi-leñosas y herbáceas que crecen en potreros. Se aplica en forma de aspersión mezclado con agua; cuando las malezas están en activo crecimiento (entre 40 y 100 cms) o antes de floración.',
    'precio_venta' => '40000.00',
    'precio_compra' => '20000.00',
    'stock_actual' => '8',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '7',
    'proveedor_id' => '2',
    'created_at' => '2026-08-26 00:21:04',
    'updated_at' => '2026-08-26 00:21:04',
  ),
  7 => 
  array (
    'id' => '9',
    'nombre' => 'fungicida e8 valle',
    'descripcion' => 'deddddddddddddddddddddddddddddddddeeeeeeeeeeeedddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd',
    'precio_venta' => '30000.00',
    'precio_compra' => '18000.00',
    'stock_actual' => '15',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '3',
    'proveedor_id' => '1',
    'created_at' => '2026-08-26 00:22:34',
    'updated_at' => '2026-08-26 00:22:34',
  ),
  8 => 
  array (
    'id' => '10',
    'nombre' => 'herbicida socio',
    'descripcion' => 'Herbicida selectivo a gramíneas y sistémico; recomendado para controlar malezas de hoja ancha, leñosas, semi-leñosas y herbáceas que crecen en potreros. Se aplica en forma de aspersión mezclado con agua; cuando las malezas están en activo crecimiento (entre 40 y 100 cms) o antes de floración.',
    'precio_venta' => '20000.00',
    'precio_compra' => '9000.00',
    'stock_actual' => '20',
    'stock_minimo' => '2',
    'estado' => 'Activo',
    'categoria_id' => '6',
    'proveedor_id' => '3',
    'created_at' => '2026-08-26 00:24:17',
    'updated_at' => '2026-08-26 00:24:17',
  ),
  9 => 
  array (
    'id' => '11',
    'nombre' => 'herbicida diestro 120 ec',
    'descripcion' => 'Herbicida sistémico postemergente para el control de gramíneas en cultivos de algodón, cebolla, tomate, zanahoria y soya',
    'precio_venta' => '35000.00',
    'precio_compra' => '12000.00',
    'stock_actual' => '25',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '6',
    'proveedor_id' => '2',
    'created_at' => '2026-08-26 00:25:21',
    'updated_at' => '2026-08-26 00:25:21',
  ),
  10 => 
  array (
    'id' => '12',
    'nombre' => 'insecticida 000',
    'descripcion' => 'insecticida encargada en la eliminacion de plaga en las chapolas',
    'precio_venta' => '50000.00',
    'precio_compra' => '29000.00',
    'stock_actual' => '22',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '1',
    'proveedor_id' => '3',
    'created_at' => '2026-08-26 00:27:24',
    'updated_at' => '2026-08-26 18:26:59',
  ),
  11 => 
  array (
    'id' => '13',
    'nombre' => 'Herbicida Camp10L',
    'descripcion' => 'Es un productos relacionado a las hierbas',
    'precio_venta' => '80000.00',
    'precio_compra' => '30000.00',
    'stock_actual' => '15',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '6',
    'proveedor_id' => '2',
    'created_at' => '2026-08-26 01:51:48',
    'updated_at' => '2026-08-26 01:51:48',
  ),
  12 => 
  array (
    'id' => '14',
    'nombre' => 'Fungicidad 0102L',
    'descripcion' => 'productoooooooooooooooooooooooo',
    'precio_venta' => '60000.00',
    'precio_compra' => '25000.00',
    'stock_actual' => '18',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '3',
    'proveedor_id' => '3',
    'created_at' => '2026-08-26 01:53:20',
    'updated_at' => '2026-08-26 01:53:20',
  ),
  13 => 
  array (
    'id' => '15',
    'nombre' => 'herbicida x 11 L',
    'descripcion' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'precio_venta' => '45000.00',
    'precio_compra' => '20000.00',
    'stock_actual' => '10',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '6',
    'proveedor_id' => '3',
    'created_at' => '2026-08-26 01:54:33',
    'updated_at' => '2026-08-26 01:54:33',
  ),
  14 => 
  array (
    'id' => '16',
    'nombre' => 'insectisida 9000',
    'descripcion' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'precio_venta' => '70000.00',
    'precio_compra' => '35000.00',
    'stock_actual' => '11',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '1',
    'proveedor_id' => '1',
    'created_at' => '2026-08-26 01:55:41',
    'updated_at' => '2026-09-24 16:38:12',
  ),
  15 => 
  array (
    'id' => '17',
    'nombre' => 'Abono coffeeE',
    'descripcion' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'precio_venta' => '35000.00',
    'precio_compra' => '14000.00',
    'stock_actual' => '15',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '8',
    'proveedor_id' => '4',
    'created_at' => '2026-08-26 01:56:49',
    'updated_at' => '2026-09-24 15:31:10',
  ),
  16 => 
  array (
    'id' => '18',
    'nombre' => 'CaféClean 480 SL',
    'descripcion' => 'Control de malezas que compiten con el cultivo de café.',
    'precio_venta' => '100000.00',
    'precio_compra' => '50000.00',
    'stock_actual' => '8',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '6',
    'proveedor_id' => '3',
    'created_at' => '2026-09-24 17:11:26',
    'updated_at' => '2026-09-24 18:33:46',
  ),
  17 => 
  array (
    'id' => '19',
    'nombre' => 'HerbiCampo 200 SL',
    'descripcion' => 'Ayuda a controlar malezas de hoja ancha y gramíneas.',
    'precio_venta' => '80000.00',
    'precio_compra' => '40000.00',
    'stock_actual' => '20',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '6',
    'proveedor_id' => '3',
    'created_at' => '2026-09-24 17:15:15',
    'updated_at' => '2026-09-24 17:15:27',
  ),
  18 => 
  array (
    'id' => '20',
    'nombre' => 'xxxxxx',
    'descripcion' => 'xxxxxxxx',
    'precio_venta' => '19999.99',
    'precio_compra' => '10000.00',
    'stock_actual' => '10',
    'stock_minimo' => '5',
    'estado' => 'Activo',
    'categoria_id' => '10',
    'proveedor_id' => '3',
    'created_at' => '2026-09-24 18:28:29',
    'updated_at' => '2026-09-24 18:28:29',
  ),
);
            foreach ($data as $row) {
                try {
                    DB::table('productos')->updateOrInsert(['id' => $row['id']], $row);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Error insertando en productos id={$row['id']}: " . $e->getMessage());
                }
            }
            $this->command?->info('Tabla productos poblada con éxito.');
        }

        // Tabla inventarios (19 registros)
        if (Schema::hasTable('inventarios')) {
            $data = array (
  0 => 
  array (
    'id' => '1',
    'stock_actual' => '25',
    'stock_reservado' => '0',
    'stock_disponible' => '25',
    'fecha_actualizacion' => '2026-08-12 11:30:40',
    'producto_id' => '2',
    'created_at' => '2026-08-12 11:30:40',
    'updated_at' => '2026-08-26 00:41:21',
  ),
  1 => 
  array (
    'id' => '2',
    'stock_actual' => '10',
    'stock_reservado' => '0',
    'stock_disponible' => '10',
    'fecha_actualizacion' => '2026-08-12 11:30:41',
    'producto_id' => '3',
    'created_at' => '2026-08-12 11:30:41',
    'updated_at' => '2026-08-26 00:33:57',
  ),
  2 => 
  array (
    'id' => '3',
    'stock_actual' => '10',
    'stock_reservado' => '0',
    'stock_disponible' => '10',
    'fecha_actualizacion' => '2026-08-25 20:34:03',
    'producto_id' => '4',
    'created_at' => '2026-08-25 20:34:03',
    'updated_at' => '2026-08-25 20:34:03',
  ),
  3 => 
  array (
    'id' => '4',
    'stock_actual' => '21',
    'stock_reservado' => '2',
    'stock_disponible' => '19',
    'fecha_actualizacion' => '2026-08-25 20:38:03',
    'producto_id' => '5',
    'created_at' => '2026-08-25 20:38:03',
    'updated_at' => '2026-08-26 18:25:18',
  ),
  4 => 
  array (
    'id' => '5',
    'stock_actual' => '12',
    'stock_reservado' => '0',
    'stock_disponible' => '12',
    'fecha_actualizacion' => '2026-08-25 23:56:38',
    'producto_id' => '6',
    'created_at' => '2026-08-25 23:56:38',
    'updated_at' => '2026-08-25 23:56:38',
  ),
  5 => 
  array (
    'id' => '6',
    'stock_actual' => '20',
    'stock_reservado' => '0',
    'stock_disponible' => '20',
    'fecha_actualizacion' => '2026-08-26 00:02:43',
    'producto_id' => '7',
    'created_at' => '2026-08-26 00:02:43',
    'updated_at' => '2026-08-26 00:02:43',
  ),
  6 => 
  array (
    'id' => '7',
    'stock_actual' => '8',
    'stock_reservado' => '0',
    'stock_disponible' => '8',
    'fecha_actualizacion' => '2026-08-26 00:21:04',
    'producto_id' => '8',
    'created_at' => '2026-08-26 00:21:04',
    'updated_at' => '2026-08-26 00:21:04',
  ),
  7 => 
  array (
    'id' => '8',
    'stock_actual' => '15',
    'stock_reservado' => '0',
    'stock_disponible' => '15',
    'fecha_actualizacion' => '2026-08-26 00:22:34',
    'producto_id' => '9',
    'created_at' => '2026-08-26 00:22:34',
    'updated_at' => '2026-08-26 00:22:34',
  ),
  8 => 
  array (
    'id' => '9',
    'stock_actual' => '20',
    'stock_reservado' => '5',
    'stock_disponible' => '15',
    'fecha_actualizacion' => '2026-08-26 00:24:17',
    'producto_id' => '10',
    'created_at' => '2026-08-26 00:24:17',
    'updated_at' => '2026-08-26 14:30:28',
  ),
  9 => 
  array (
    'id' => '10',
    'stock_actual' => '25',
    'stock_reservado' => '0',
    'stock_disponible' => '25',
    'fecha_actualizacion' => '2026-08-26 00:25:21',
    'producto_id' => '11',
    'created_at' => '2026-08-26 00:25:21',
    'updated_at' => '2026-08-26 00:25:21',
  ),
  10 => 
  array (
    'id' => '11',
    'stock_actual' => '22',
    'stock_reservado' => '0',
    'stock_disponible' => '22',
    'fecha_actualizacion' => '2026-08-26 00:27:24',
    'producto_id' => '12',
    'created_at' => '2026-08-26 00:27:24',
    'updated_at' => '2026-08-26 18:26:59',
  ),
  11 => 
  array (
    'id' => '12',
    'stock_actual' => '15',
    'stock_reservado' => '0',
    'stock_disponible' => '15',
    'fecha_actualizacion' => '2026-08-26 01:51:53',
    'producto_id' => '13',
    'created_at' => '2026-08-26 01:51:53',
    'updated_at' => '2026-08-26 01:51:53',
  ),
  12 => 
  array (
    'id' => '13',
    'stock_actual' => '18',
    'stock_reservado' => '0',
    'stock_disponible' => '18',
    'fecha_actualizacion' => '2026-08-26 01:53:23',
    'producto_id' => '14',
    'created_at' => '2026-08-26 01:53:23',
    'updated_at' => '2026-08-26 01:53:23',
  ),
  13 => 
  array (
    'id' => '14',
    'stock_actual' => '10',
    'stock_reservado' => '0',
    'stock_disponible' => '10',
    'fecha_actualizacion' => '2026-08-26 01:54:33',
    'producto_id' => '15',
    'created_at' => '2026-08-26 01:54:33',
    'updated_at' => '2026-08-26 01:54:33',
  ),
  14 => 
  array (
    'id' => '15',
    'stock_actual' => '11',
    'stock_reservado' => '1',
    'stock_disponible' => '10',
    'fecha_actualizacion' => '2026-08-26 01:55:42',
    'producto_id' => '16',
    'created_at' => '2026-08-26 01:55:42',
    'updated_at' => '2026-09-24 16:38:12',
  ),
  15 => 
  array (
    'id' => '16',
    'stock_actual' => '15',
    'stock_reservado' => '0',
    'stock_disponible' => '15',
    'fecha_actualizacion' => '2026-08-26 01:56:50',
    'producto_id' => '17',
    'created_at' => '2026-08-26 01:56:50',
    'updated_at' => '2026-09-15 01:06:25',
  ),
  16 => 
  array (
    'id' => '17',
    'stock_actual' => '8',
    'stock_reservado' => '0',
    'stock_disponible' => '8',
    'fecha_actualizacion' => '2026-09-24 17:11:29',
    'producto_id' => '18',
    'created_at' => '2026-09-24 17:11:29',
    'updated_at' => '2026-09-24 18:33:46',
  ),
  17 => 
  array (
    'id' => '18',
    'stock_actual' => '20',
    'stock_reservado' => '0',
    'stock_disponible' => '20',
    'fecha_actualizacion' => '2026-09-24 17:15:15',
    'producto_id' => '19',
    'created_at' => '2026-09-24 17:15:15',
    'updated_at' => '2026-09-24 17:15:27',
  ),
  18 => 
  array (
    'id' => '19',
    'stock_actual' => '10',
    'stock_reservado' => '0',
    'stock_disponible' => '10',
    'fecha_actualizacion' => '2026-09-24 18:28:29',
    'producto_id' => '20',
    'created_at' => '2026-09-24 18:28:29',
    'updated_at' => '2026-09-24 18:28:29',
  ),
);
            foreach ($data as $row) {
                try {
                    DB::table('inventarios')->updateOrInsert(['id' => $row['id']], $row);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Error insertando en inventarios id={$row['id']}: " . $e->getMessage());
                }
            }
            $this->command?->info('Tabla inventarios poblada con éxito.');
        }

        // Tabla imagenes (47 registros)
        if (Schema::hasTable('imagenes')) {
            $data = array (
  0 => 
  array (
    'id' => '7',
    'url_imagen' => 'productos/1787690041_0_Bangot_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '4',
    'created_at' => '2026-08-25 20:34:03',
    'updated_at' => '2026-08-25 20:34:03',
  ),
  1 => 
  array (
    'id' => '8',
    'url_imagen' => 'productos/1787690043_1_CAMPERO-4LT.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '4',
    'created_at' => '2026-08-25 20:34:03',
    'updated_at' => '2026-08-25 20:34:03',
  ),
  2 => 
  array (
    'id' => '9',
    'url_imagen' => 'productos/1787690043_2_ciclope-500-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '4',
    'created_at' => '2026-08-25 20:34:03',
    'updated_at' => '2026-08-25 20:34:03',
  ),
  3 => 
  array (
    'id' => '10',
    'url_imagen' => 'productos/1787690283_0_FertinvesaProduccion_1Kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '5',
    'created_at' => '2026-08-25 20:38:03',
    'updated_at' => '2026-08-25 20:38:03',
  ),
  4 => 
  array (
    'id' => '11',
    'url_imagen' => 'productos/1787690283_1_Invetrina_1Lt_TE-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '5',
    'created_at' => '2026-08-25 20:38:03',
    'updated_at' => '2026-08-25 20:38:03',
  ),
  5 => 
  array (
    'id' => '12',
    'url_imagen' => 'productos/1787690358_0_FertinvesaBananoPlatano_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '2',
    'created_at' => '2026-08-25 20:39:18',
    'updated_at' => '2026-08-25 20:39:18',
  ),
  6 => 
  array (
    'id' => '13',
    'url_imagen' => 'productos/1787702195_0_Rotundo_presentaciones-scaled.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '6',
    'created_at' => '2026-08-25 23:56:38',
    'updated_at' => '2026-08-25 23:56:38',
  ),
  7 => 
  array (
    'id' => '14',
    'url_imagen' => 'productos/1787702198_1_Invetrina_1Lt_TE-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '6',
    'created_at' => '2026-08-25 23:56:38',
    'updated_at' => '2026-08-25 23:56:38',
  ),
  8 => 
  array (
    'id' => '15',
    'url_imagen' => 'productos/1787702563_0_CAMPERO-4LT.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '7',
    'created_at' => '2026-08-26 00:02:43',
    'updated_at' => '2026-08-26 00:02:43',
  ),
  9 => 
  array (
    'id' => '16',
    'url_imagen' => 'productos/1787702563_1_ciclope-500-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '7',
    'created_at' => '2026-08-26 00:02:43',
    'updated_at' => '2026-08-26 00:02:43',
  ),
  10 => 
  array (
    'id' => '17',
    'url_imagen' => 'productos/1787703664_0_BALTIC_1L.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '8',
    'created_at' => '2026-08-26 00:21:04',
    'updated_at' => '2026-08-26 00:21:04',
  ),
  11 => 
  array (
    'id' => '18',
    'url_imagen' => 'productos/1787703664_1_FertinvesaProduccion_1Kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '8',
    'created_at' => '2026-08-26 00:21:04',
    'updated_at' => '2026-08-26 00:21:04',
  ),
  12 => 
  array (
    'id' => '19',
    'url_imagen' => 'productos/1787703664_2_socio-267-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '8',
    'created_at' => '2026-08-26 00:21:04',
    'updated_at' => '2026-08-26 00:21:04',
  ),
  13 => 
  array (
    'id' => '20',
    'url_imagen' => 'productos/1787703754_0_ciclope-500-600x600.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '9',
    'created_at' => '2026-08-26 00:22:34',
    'updated_at' => '2026-08-26 00:22:34',
  ),
  14 => 
  array (
    'id' => '21',
    'url_imagen' => 'productos/1787703754_1_FertinvesaInicio_1kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '9',
    'created_at' => '2026-08-26 00:22:34',
    'updated_at' => '2026-08-26 00:22:34',
  ),
  15 => 
  array (
    'id' => '22',
    'url_imagen' => 'productos/1787703754_2_Rotundo_presentaciones-scaled.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '9',
    'created_at' => '2026-08-26 00:22:34',
    'updated_at' => '2026-08-26 00:22:34',
  ),
  16 => 
  array (
    'id' => '23',
    'url_imagen' => 'productos/1787703857_0_FertinvesaProduccion_1Kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '10',
    'created_at' => '2026-08-26 00:24:17',
    'updated_at' => '2026-08-26 00:24:17',
  ),
  17 => 
  array (
    'id' => '24',
    'url_imagen' => 'productos/1787703857_1_Bangot_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '10',
    'created_at' => '2026-08-26 00:24:17',
    'updated_at' => '2026-08-26 00:24:17',
  ),
  18 => 
  array (
    'id' => '25',
    'url_imagen' => 'productos/1787703921_0_Colision_1Lt-1-600x600.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '11',
    'created_at' => '2026-08-26 00:25:21',
    'updated_at' => '2026-08-26 00:25:21',
  ),
  19 => 
  array (
    'id' => '26',
    'url_imagen' => 'productos/1787703921_1_DestierroSL_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '11',
    'created_at' => '2026-08-26 00:25:21',
    'updated_at' => '2026-08-26 00:25:21',
  ),
  20 => 
  array (
    'id' => '27',
    'url_imagen' => 'productos/1787703921_2_FertinvesaBananoPlatano_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '11',
    'created_at' => '2026-08-26 00:25:21',
    'updated_at' => '2026-08-26 00:25:21',
  ),
  21 => 
  array (
    'id' => '28',
    'url_imagen' => 'productos/1787703921_3_FertinvesaInicio_1kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '11',
    'created_at' => '2026-08-26 00:25:21',
    'updated_at' => '2026-08-26 00:25:21',
  ),
  22 => 
  array (
    'id' => '29',
    'url_imagen' => 'productos/1787704044_0_CAMPERO-4LT.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '12',
    'created_at' => '2026-08-26 00:27:24',
    'updated_at' => '2026-08-26 00:27:24',
  ),
  23 => 
  array (
    'id' => '30',
    'url_imagen' => 'productos/1787704044_1_DestierroSL_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '12',
    'created_at' => '2026-08-26 00:27:24',
    'updated_at' => '2026-08-26 00:27:24',
  ),
  24 => 
  array (
    'id' => '31',
    'url_imagen' => 'productos/1787704044_2_FertinvesaProduccion_1Kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '12',
    'created_at' => '2026-08-26 00:27:24',
    'updated_at' => '2026-08-26 00:27:24',
  ),
  25 => 
  array (
    'id' => '32',
    'url_imagen' => 'productos/1787704376_0_FertinvesaInicio_1kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '3',
    'created_at' => '2026-08-26 00:32:56',
    'updated_at' => '2026-08-26 00:32:56',
  ),
  26 => 
  array (
    'id' => '33',
    'url_imagen' => 'productos/1787709110_0_Bangot_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '13',
    'created_at' => '2026-08-26 01:51:51',
    'updated_at' => '2026-08-26 01:51:51',
  ),
  27 => 
  array (
    'id' => '34',
    'url_imagen' => 'productos/1787709113_1_DestierroSL_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '13',
    'created_at' => '2026-08-26 01:51:53',
    'updated_at' => '2026-08-26 01:51:53',
  ),
  28 => 
  array (
    'id' => '35',
    'url_imagen' => 'productos/1787709113_2_FertinvesaBananoPlatano_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '13',
    'created_at' => '2026-08-26 01:51:53',
    'updated_at' => '2026-08-26 01:51:53',
  ),
  29 => 
  array (
    'id' => '36',
    'url_imagen' => 'productos/1787709201_0_FertinvesaInicio_1kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '14',
    'created_at' => '2026-08-26 01:53:21',
    'updated_at' => '2026-08-26 01:53:21',
  ),
  30 => 
  array (
    'id' => '37',
    'url_imagen' => 'productos/1787709201_1_FertinvesaProduccion_1Kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '14',
    'created_at' => '2026-08-26 01:53:21',
    'updated_at' => '2026-08-26 01:53:21',
  ),
  31 => 
  array (
    'id' => '38',
    'url_imagen' => 'productos/1787709201_2_Rotundo_presentaciones-scaled.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '14',
    'created_at' => '2026-08-26 01:53:21',
    'updated_at' => '2026-08-26 01:53:21',
  ),
  32 => 
  array (
    'id' => '39',
    'url_imagen' => 'productos/1787709273_0_socio-267-600x600.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '15',
    'created_at' => '2026-08-26 01:54:33',
    'updated_at' => '2026-08-26 01:54:33',
  ),
  33 => 
  array (
    'id' => '40',
    'url_imagen' => 'productos/1787709273_1_ciclope-500-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '15',
    'created_at' => '2026-08-26 01:54:33',
    'updated_at' => '2026-08-26 01:54:33',
  ),
  34 => 
  array (
    'id' => '41',
    'url_imagen' => 'productos/1787709341_0_Colision_1Lt-1-600x600.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '16',
    'created_at' => '2026-08-26 01:55:41',
    'updated_at' => '2026-08-26 01:55:41',
  ),
  35 => 
  array (
    'id' => '42',
    'url_imagen' => 'productos/1787709341_1_DestierroSL_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '16',
    'created_at' => '2026-08-26 01:55:41',
    'updated_at' => '2026-08-26 01:55:41',
  ),
  36 => 
  array (
    'id' => '43',
    'url_imagen' => 'productos/1787709341_2_FertinvesaBananoPlatano_1Lt-600x600.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '16',
    'created_at' => '2026-08-26 01:55:41',
    'updated_at' => '2026-08-26 01:55:41',
  ),
  37 => 
  array (
    'id' => '44',
    'url_imagen' => 'productos/1787709409_0_BALTIC_1L.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '17',
    'created_at' => '2026-08-26 01:56:50',
    'updated_at' => '2026-08-26 01:56:50',
  ),
  38 => 
  array (
    'id' => '45',
    'url_imagen' => 'productos/1787709410_1_CAMPERO-4LT.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '17',
    'created_at' => '2026-08-26 01:56:50',
    'updated_at' => '2026-08-26 01:56:50',
  ),
  39 => 
  array (
    'id' => '46',
    'url_imagen' => 'productos/1787709410_2_FertinvesaInicio_1kg-600x692.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '17',
    'created_at' => '2026-08-26 01:56:50',
    'updated_at' => '2026-08-26 01:56:50',
  ),
  40 => 
  array (
    'id' => '47',
    'url_imagen' => 'productos/1790269886_0_prod_69ff85f4699984.23027691.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '18',
    'created_at' => '2026-09-24 17:11:28',
    'updated_at' => '2026-09-24 17:11:28',
  ),
  41 => 
  array (
    'id' => '48',
    'url_imagen' => 'productos/1790269889_1_prod_69ff86a32837b1.51743552.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '18',
    'created_at' => '2026-09-24 17:11:29',
    'updated_at' => '2026-09-24 17:11:29',
  ),
  42 => 
  array (
    'id' => '49',
    'url_imagen' => 'productos/1790269889_2_prod_69ff88c8cd0f30.17589836.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '18',
    'created_at' => '2026-09-24 17:11:29',
    'updated_at' => '2026-09-24 17:11:29',
  ),
  43 => 
  array (
    'id' => '50',
    'url_imagen' => 'productos/1790270115_0_prod_69ff842b715f46.13604788.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '19',
    'created_at' => '2026-09-24 17:15:15',
    'updated_at' => '2026-09-24 17:15:15',
  ),
  44 => 
  array (
    'id' => '51',
    'url_imagen' => 'productos/1790270115_1_prod_69ff859f9694b7.62981418.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '19',
    'created_at' => '2026-09-24 17:15:15',
    'updated_at' => '2026-09-24 17:15:15',
  ),
  45 => 
  array (
    'id' => '52',
    'url_imagen' => 'productos/1790270115_2_prod_69ff859f860532.51920580.png',
    'descripcion' => NULL,
    'principal' => '0',
    'producto_id' => '19',
    'created_at' => '2026-09-24 17:15:15',
    'updated_at' => '2026-09-24 17:15:15',
  ),
  46 => 
  array (
    'id' => '53',
    'url_imagen' => 'productos/1790274509_0_prod_69ff83c095ad46.11016704.png',
    'descripcion' => NULL,
    'principal' => '1',
    'producto_id' => '20',
    'created_at' => '2026-09-24 18:28:29',
    'updated_at' => '2026-09-24 18:28:29',
  ),
);
            foreach ($data as $row) {
                try {
                    DB::table('imagenes')->updateOrInsert(['id' => $row['id']], $row);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning("Error insertando en imagenes id={$row['id']}: " . $e->getMessage());
                }
            }
            $this->command?->info('Tabla imagenes poblada con éxito.');
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        } catch (\Throwable $e) {}
    }
}
