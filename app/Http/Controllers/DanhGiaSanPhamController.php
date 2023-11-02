<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuiDanhGiaRequest;
use App\Models\DanhGiaSanPham;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class DanhGiaSanPhamController extends Controller
{
    public function removeDanhGia($id,Request $request){

        $check = DanhGiaSanPham::where('id',$id)
                            ->where("id_sp",$request->id_sp)
                            ->where("id_user",Auth::guard('khach')->user()->id)
                            ->first();
        if($check){
            $check->delete();
            return response()->json([
                'status' => true,
                'message'=>'Xóa Đánh Giá Thành Công',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'=>'Xóa Đánh Giá Thất Bại',
            ]);
        }
    }
    public function guiDanhGia(GuiDanhGiaRequest $request)
    {
        if(DanhGiaSanPham::checkDanhGia(Auth::guard('khach')->user()->id,$request->id_san_pham)){
            return response()->json([
                'status' => false,
                'message'=>'Bạn Chỉ Có Thể Đánh Giá 1 Lần',
            ]);
        }
        if (DanhGiaSanPham::getThoiGian(Auth::guard('khach')->user()->id, $request->id_san_pham, 15)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chỉ được phép đánh giá mỗi 15 phút.',
            ]);
        }
        DanhGiaSanPham::create([
            'id_user' => Auth::guard('khach')->user()->id,
            'id_sp' => $request->id_san_pham,
            'name' => $request->name,
            'noi_dung' => $request->noi_dung,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Đánh Giá Thành Công',
        ]);
    }
    public function danhGiaData(Request $request)
    {
        $data = DanhGiaSanPham::where("id_sp", $request->id)->orderBy('created_at', 'desc')->paginate(5);
        $ownData = DanhGiaSanPham::where("id_sp", $request->id)
            ->where("id_user", Auth::guard('khach')->user()->id)->orderBy('created_at', 'desc')->pluck('id')
            ->toArray();;
        foreach ($data as $item) {
            if (in_array($item->id, $ownData)) {
                $item->ownComment = 1;
            } else {
                $item->ownComment = 0;
            }
            $created_at = Carbon::parse($item->created_at);
            $created_at->setTimezone('Asia/Ho_Chi_Minh');
            $item->rate = Rate::where("id_sp",$item->id_sp)->where("id_user",$item->id_user)->first()->rate ? Rate::where("id_sp",$item->id_sp)->where("id_user",$item->id_user)->first()->rate : '5';
            $item->created_at_formatted = $created_at->format('d/m/Y H:i:s');
        }
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
}
