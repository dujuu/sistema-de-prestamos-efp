<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'idPersona' => 1,
                'estadoSancion' => 'Activo',
                'Contrasena' => Hash::make('admin123'),
                'Email' => 'juan.meneses75m@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPersona' => 2,
                'estadoSancion' => 'Activo',
                'Contrasena' => Hash::make('alumno123'),
                'Email' => 'juan.meneses.munoz@alumnos.uta.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPersona' => 3,
                'estadoSancion' => 'Activo',
                'Contrasena' => Hash::make('kevin123'),
                'Email' => 'kevin.rojas@alumnos.uta.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPersona' => 4,
                'estadoSancion' => 'Activo',
                'Contrasena' => Hash::make('pablo123'),
                'Email' => 'pablo.valladares@alumnos.uta.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPersona' => 5,
                'estadoSancion' => 'Activo',
                'Contrasena' => Hash::make('andrea123'),
                'Email' => 'andrea.navia@alumnos.uta.cl',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Asignar roles
        DB::table('rol_user')->insert([
            ['idRol' => 1, 'idUser' => 1, 'created_at' => now(), 'updated_at' => now()], // Admin
            ['idRol' => 2, 'idUser' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['idRol' => 2, 'idUser' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['idRol' => 2, 'idUser' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['idRol' => 2, 'idUser' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

         $usersExtra = [];
        $rolesExtra = [];

        // El último user fue el ID = 5.
        $nextUserId = 6;

        for ($i = 6; $i <= 205; $i++) {

            $usersExtra[] = [
                'idPersona' => $i,
                'estadoSancion' => 'Activo',
                'Contrasena' => Hash::make('password123'),
                'Email' => "persona{$i}@example.com",
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Cada user nuevo es alumno (rol 2)
            $rolesExtra[] = [
                'idRol' => 2,
                'idUser' => $nextUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $nextUserId++;
        }

        DB::table('users')->insert($usersExtra);
        DB::table('rol_user')->insert($rolesExtra);
    }
}
