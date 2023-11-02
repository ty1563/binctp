<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    use HasFactory;
    protected $table ="histories";
    protected $fillable = [
       "id_khach",
       "id_san_pham",
       "key",
       "thoi_gian",
       "gia_ban",
       "type",
    ];
}
