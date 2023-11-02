<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuyenMuc extends Model
{
    use HasFactory;
    protected $table ="chuyen_mucs";
    protected $fillable = [
        'id',
        'ten_chuyen_muc',
        'slug_chuyen_muc',
        'status',
    ];
}
