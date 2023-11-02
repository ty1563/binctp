<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    use HasFactory;
    protected $table ="cau_hois";
    protected $fillable = [
        "cau_hoi",
        "tra_loi",
        "xep_hang",
    ];
}
