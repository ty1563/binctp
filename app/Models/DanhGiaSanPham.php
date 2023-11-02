<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGiaSanPham extends Model
{
    use HasFactory;
    protected $table = 'danh_gia_san_phams';
    protected $fillable = [
        'id_user',
        'id_sp',
        'name',
        'noi_dung',
    ];
    public static function getThoiGian($userId, $productId, $minutes)
    {
        $now = Carbon::now();
        $recentReview = self::where('id_user', $userId)
            ->where('id_sp', $productId)
            ->where('created_at', '>', $now->subMinutes($minutes))
            ->exists();

        return $recentReview;
    }
    public static function checkDanhGia($id_user,$id_sp){
        $check = self::where("id_user",$id_user)
                ->where("id_sp",$id_sp)
                ->first();
        return $check;
    }
    public static function layThoiGian($time){
        return date_format($time,"Y/m/d H:i:s");
    }
}
