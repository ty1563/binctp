<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\LichSuNapTien;
use App\Models\TheCao;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function callBackTheCao()
    {
        if (isset($_GET['content']) && isset($_GET['status'])) {
            $content = explode("|", $_GET['content']);
            $user_id = $content[0];
            $menhgia = $content[1];
            $pin = $content[2];
            $seri = $content[3];
            $type = $content[4];
            $id_nap = $content[5];
            $status = $_GET['status'];

            $thucnhan = $_GET['thucnhan'];
            $check = TheCao::where('money', $menhgia)
                ->where("type", $type)
                ->where("pin", $pin)
                ->where("serial", $seri)
                ->first();
            if (!isset($check))
                return 'Thẻ Không Tồn Tại';
            if (!$check->status)
                return "Thẻ Đã Được Sử Dụng";
            if ($status === "hoantat") {
                $data = KhachHang::find($user_id);
                if ($data) {
                    $data->coin += $thucnhan;
                    $data->save();
                    $check->delete();
                    $lichSu = LichSuNapTien::where("id_nap",$id_nap)->first();
                    $lichSu->status = 1;
                    $lichSu->thucnhan = $thucnhan;
                    $lichSu->save();
                    return "Đã cộng " . $thucnhan . " vnđ cho username :  " . $data->username;
                } else {
                    return "không tìm thấy username";
                }
            } else {
                echo "Xin Chào Bạn Đến Với BinCtp.Com";
            }
        }
    }
}
