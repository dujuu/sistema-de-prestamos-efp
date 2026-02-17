<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSancionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user_sancion')->insert([
            ['idUser' => 2, 'idSancion' => 1],
            ['idUser' => 2, 'idSancion' => 2],
            ['idUser' => 3, 'idSancion' => 3],
            ['idUser' => 4, 'idSancion' => 4],
        ]);
    }
}
