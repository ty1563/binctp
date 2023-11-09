<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomGame extends Model
{
    use HasFactory;
    public $timestamp = false;
    protected $table = 'custom_games';
    protected $fillable = [
        "ten_menu",
        "tinh_trang",
        "thong_bao",
        "esp_status",
        "aimbot_status",
        "bullet_status",
        "memory_status",
    ];
}
