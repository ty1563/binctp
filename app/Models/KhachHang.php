<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class KhachHang extends Authenticatable
{
    use HasFactory;
    protected $table = 'khach_hangs';
    protected $fillable = [
        'username',
        'password',
        'email',
        'coin',
        'token',
        'status',
        'active',
        'hash_reset',
        'hash_active',
    ];
}
