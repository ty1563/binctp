<?php

use Carbon\Carbon;
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
        Schema::create('panel_games', function (Blueprint $table) {
            $table->id();
            $table->string("game");
            $table->string("user_key");
            $table->string("thoi_gian");
            $table->string("ngay_het_han")->nullable();
            $table->string("max_devices");
            $table->string("devices")->nullable();
            $table->string("status")->default(0);
            $table->string("nguoi_tao")->default("admin");
            $table->dateTime("ngay_tao")->default(Carbon::now('Asia/Ho_Chi_Minh'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panel_games');
    }
};
