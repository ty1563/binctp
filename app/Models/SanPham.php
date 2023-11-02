<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;
    protected $table ="san_phams";
    protected $fillable = [
        "ten_san_pham",
        "mo_ta",
        "hinh_anh",
        "link1",
        "link2",
        "status",
        "id_danh_muc",
    ];
}
