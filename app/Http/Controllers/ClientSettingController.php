<?php

namespace App\Http\Controllers;

use App\Models\ClientSetting;
use Illuminate\Http\Request;

use PDO;

class ClientSettingController extends Controller
{

    public function index(){
        return view('Admin.Setting.index');
    }

    public function add(Request $request){
        if(ClientSetting::count()>=2){
            return response()->json([
                'status' => false,
                'message'=>'Chỉ Được Thêm Tối Đa 2 Trang',
            ]);
        }
        $check = ClientSetting::where("page",$request->page)->first();
        if($check){
            return response()->json([
                'status' => false,
                'message'=>'Trang Đã Tồn Tại , Vui Lòng Xóa Trang Để Thêm Mới',
            ]);
        }else{
            $anh = explode(',',$request->hinh_anh);
            $anh = $anh[0];
            $request["hinh_anh"] = $anh;
            ClientSetting::create($request->all());
            return response()->json([
                'status' => true,
                'message'=>'Thêm Mới Thành Công',
            ]);
        }
    }
    public function data(){
        return response()->json([
            'status' => true,
            'data'=>ClientSetting::all(),
        ]);
    }
    public function update(Request $request){
        $check = ClientSetting::where("page",$request->page)->first();
        if($check){
            $check->update($request->all());
            return response()->json([
                'status' => true,
                'message'=>'Cập Nhật Thành Công',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'=>'Cập Nhật Thất Bại',
            ]);
        }
    }

}
