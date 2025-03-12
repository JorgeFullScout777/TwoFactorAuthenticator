<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Insertar roles
        /*
        DB::table('roles')->insert([
            ['id' => 1, 'rol' => 'Usuario'],
            ['id' => 2, 'rol' => 'Otorgador'],
            ['id' => 3, 'rol' => 'Revocador'],
            ['id' => 4, 'rol' => 'Manejador'],
            ['id' => 5, 'rol' => 'Emisor de Super Usuarios']
        ]);
        */

        // Insertar usuarios
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Jorge Usuario',
                'email' => 'jorgefullscout@gmail.com',
                'password' => Hash::make('12345678'),
                //'rol_id' => 1
                'two_factor_verified' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Jorge Otorgador',
                'email' => 'jorgefullscout2.0@gmail.com',
                'password' => Hash::make('12345678'),
                //'rol_id' => 2
                'two_factor_verified' => 0,
            ],
            [
                'id' => 3,
                'name' => 'Jorge Revocador',
                'email' => 'jorgefullscout3.0@gmail.com',
                'password' => Hash::make('12345678'),
                //'rol_id' => 3
                'two_factor_verified' => 0,
            ],
            [
                'id' => 4,
                'name' => 'Jorge Manejador',
                'email' => 'jorgefullscout4.0@gmail.com',
                'password' => Hash::make('12345678'),
                //'rol_id' => 4
                'two_factor_verified' => 0,
            ],
            [
                'id' => 5,
                'name' => 'Jorge Emisor de Super Usuarios',
                'email' => 'jorge.luna@tecnomty.com',
                'password' => Hash::make('12345678'),
                //'rol_id' => 5
                'two_factor_verified' => 0,
            ]
        ]);

        // Inserta permisos
        /*
        DB::table('permissions')->insert([
            ['id' => 1, 'permiso' => 'Create'],
            ['id' => 2, 'permiso' => 'Read'],
            ['id' => 3, 'permiso' => 'Update'],
            ['id' => 4, 'permiso' => 'Delete'],
        ]);

        // Insertar relacion roles-permisos
        DB::table('roles_x_permissions')->insert([
            ['id' => 1, 'rol_id' => 1, 'permission_id' => 1],
            ['id' => 2, 'rol_id' => 1, 'permission_id' => 2]
        ]);

        // Insertar productos
        DB::table('products')->insert([
            ['name' => 'Laptop Gamer', 'description' => 'Laptop de alto rendimiento para juegos', 'price' => 1500.00],
            ['name' => 'Smartphone', 'description' => 'Teléfono inteligente con pantalla OLED', 'price' => 800.00],
            ['name' => 'Audífonos Bluetooth', 'description' => 'Audífonos inalámbricos con cancelación de ruido', 'price' => 200.00],
            ['name' => 'Monitor 4K', 'description' => 'Monitor UHD con tasa de refresco de 144Hz', 'price' => 500.00],
            ['name' => 'Teclado Mecánico', 'description' => 'Teclado mecánico con retroiluminación RGB', 'price' => 120.00],
            ['name' => 'Silla Ergonómica', 'description' => 'Silla de oficina ergonómica con soporte lumbar', 'price' => 300.00],
        ]);
        */
    }
}
