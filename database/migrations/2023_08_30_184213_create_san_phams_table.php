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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string("ten_san_pham");
            $table->string("mo_ta");
            $table->string("hinh_anh");
            $table->string("link1")->default(null);
            $table->string("link2")->default(null);
            $table->string("status")->default(1);
            $table->string("id_danh_muc");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('san_phams');
    }
};
