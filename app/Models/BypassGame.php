<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BypassGame extends Model
{
    use HasFactory;
    protected $table = "bypass_games";
    protected $fillable = [
       "lib_name",
       "offset",
       "patch",
    ];
}
