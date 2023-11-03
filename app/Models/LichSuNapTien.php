<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuNapTien extends Model
{
    use HasFactory;
    protected $table = "lich_su_nap_tiens";
    protected $fillable = [
        "user_id",
        "type",
        "total",
        "thucnhan",
        "status",
        "id_nap",
    ];
    public function getTongTien(){
        $tongTien = KhachHang::find($this->user_id)->first()->coin;
        return $tongTien+=$this->total;
    }
    public function getThoiGian(){
        return Carbon::parse($this->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s');
    }
}
