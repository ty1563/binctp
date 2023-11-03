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
        Schema::create('lich_su_nap_tiens', function (Blueprint $table) {
            $table->id();
            $table->smallInteger("user_id");
            $table->string("type",50);
            $table->string("total",50);
            $table->string("thucnhan",50);
            $table->string("id_nap",50);
            $table->string("status",50)->default(-1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_su_nap_tiens');
    }
};
