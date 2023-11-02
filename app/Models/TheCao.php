<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheCao extends Model
{
    use HasFactory;
    protected $table = "the_caos";
    protected $fillable = [
        "serial",
        "pin",
        "money",
        "type",
        "user_id",
        "messages",
        "status",
    ];
}
