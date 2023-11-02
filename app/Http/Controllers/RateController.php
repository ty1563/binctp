<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function rate(Request $request)
    {

        if (!Auth::guard('khach')->check()) {
            return redirect()->route('login');
        }
        $id_user = Auth::guard('khach')->user()->id;
        $check = rate::where("id_user", $id_user)
            ->where('id_sp', $request->id)
            ->first();
        if ($request->rate <= 5 && $request->rate >= 1) {
            if ($check) {
                $check->rate = $request->rate;
                $check->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Đánh Giá Của Bạn Đã Được Cập Nhật Thành '. $request->rate . ' Sao' ,
                ]);
            } else {
                rate::create([
                    'rate' => $request->rate,
                    'id_sp' => $request->id,
                    'id_user' => $id_user,
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Đánh Giá '.$request->rate.' Sao Thành Công',
                ]);
            }


        } else {
            return response()->json([
                'status' => false,
                'message' => 'Đánh Giá Thất Bại',
            ]);
        }
    }
}
