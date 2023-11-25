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
        Schema::create('chuyen_mucs', function (Blueprint $table) {
            $table->id();
            $table->string("ten_chuyen_muc");
            $table->string("slug_chuyen_muc");
            $table->string("status");
            $table->string("loai");
            $table->string("logo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chuyen_mucs');
    }
};
