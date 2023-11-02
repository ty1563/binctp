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
        Schema::create('thong_tins', function (Blueprint $table) {
            $table->id();
            $table->string("full_name")->nullable();
            $table->string("title")->nullable();
            $table->string("noi_dung")->nullable();
            $table->string("hinh_anh")->nullable();
            $table->string("mo_ta")->nullable();
            $table->string("facebook")->nullable();
            $table->string("zalo")->nullable();
            $table->string("sdt")->nullable();
            $table->string("instagram")->nullable();
            $table->string("telegram")->nullable();
            $table->string("messenger")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_tins');
    }
};
