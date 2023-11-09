<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamePanelSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('custom_games')->insert([
            [
                "ten_menu" => 'TOSAN PROMAX VNG',
                "tinh_trang" => 1,
                "thong_bao" => '',
                "esp_status" => 1,
                "aimbot_status" => 1,
                "bullet_status" => 1,
                "memory_status" => 1,
            ],
        ]);
    }
}
