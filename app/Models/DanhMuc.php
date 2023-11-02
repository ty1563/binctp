<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;
    protected $table = "danh_mucs";
    protected $fillable =[
        "ten_danh_muc",
        "mo_ta",
        "slug_danh_muc",
        "hinh_anh",
        "id_chuyen_muc",
        "xep_hang",
    ];
}
