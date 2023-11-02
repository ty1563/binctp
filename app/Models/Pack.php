<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    protected $table ="packs";
    protected $fillable = [
        "gia_ban",
        "thoi_gian",
        "info",
        "loai",
        "id_san_pham",
    ];
}
