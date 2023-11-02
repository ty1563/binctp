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
        Schema::create('the_caos', function (Blueprint $table) {
            $table->id();
            $table->string("serial");
            $table->string("pin");
            $table->string("money");
            $table->string("type")->nullable();
            $table->string("user_id");
            $table->string("messages");
            $table->string("status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('the_caos');
    }
};
