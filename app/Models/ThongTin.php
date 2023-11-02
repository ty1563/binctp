<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongTin extends Model
{
    use HasFactory;
    protected $table = "thong_tins";
    public $timestamps = false;
    protected $fillable = [
        "full_name",
        "title",
        "noi_dung",
        "hinh_anh",
        "mo_ta",
        "facebook",
        "zalo",
        "sdt",
        "instagram",
        "telegram",
        "messenger",
    ];
}
