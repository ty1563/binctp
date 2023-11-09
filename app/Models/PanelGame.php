<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelGame extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "panel_games";
    protected $fillable = [
        "game",
        "user_key",
        "thoi_gian",
        "ngay_het_han",
        "max_devices",
        "devices",
        "status",
        "nguoi_tao",
        "ngay_tao",
    ];
}
