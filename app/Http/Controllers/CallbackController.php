<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\TheCao;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function callBackTheCao()
    {
        if (isset($_GET['content']) && isset($_GET['status'])) {
            $content = $_GET['content'];
            $status = $_GET['status'];
            $thucnhan = $_GET['thucnhan'];
            $check = TheCao::where('user_id', $content)
                            ->where('money','!=','0')
                            ->first();
            if ($check->status === 1) {
                if ($status == "hoantat") {
                    $data = KhachHang::find($content);
                    if ($data) {
                        $data->coin += $thucnhan;
                        $data->save();
                        $check->money = 0;
                        $check->status = 0;
                        $check->save();
                        echo "thanh cong";
                    } else {
                        echo "khong tim thay";
                    }
                }
            } else {
                echo "Xin Chào Bạn Đến Với BinCtp.Com";
            }
        }
    }
}
