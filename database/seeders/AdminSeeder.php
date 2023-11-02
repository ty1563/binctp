<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'email'             =>  'nguyenvanty2k9@gmail.com',
                'password'          =>  bcrypt('123456'),
                'username'          =>  'vanty120',
                'sdt'               =>  '0366508231',
                'id_quyen'          =>  'is_master',
            ],
        ]);
    }
}
