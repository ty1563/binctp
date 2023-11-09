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
        Schema::create('custom_games', function (Blueprint $table) {
            $table->string("ten_menu")->nullable();
            $table->string("tinh_trang")->nullable();
            $table->string("thong_bao")->nullable();
            $table->smallInteger("esp_status")->nullable();
            $table->smallInteger("aimbot_status")->nullable();
            $table->smallInteger("bullet_status")->nullable();
            $table->smallInteger("memory_status")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_games');
    }
};
