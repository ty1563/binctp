<?php

namespace App\Http\Controllers;

use App\Models\ChuyenMuc;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChuyenMucController extends Controller
{
    public function index(){
        if($this->check_admin_get('quyen_chuyen_muc') || $this->check_admin_get('is_master'))
        return view('Admin.ChuyenMuc.index');
        else {
            toastr()->error("Bạn Không Có Quyền Này");
            return redirect('/admin');
        }
    }
    public function add(Request $request){
        $request["slug_chuyen_muc"] = Str::slug($request->ten_chuyen_muc);
        $check =  ChuyenMuc::where("slug_chuyen_muc",$request->slug_chuyen_muc)->first();
        if($check){
            return response()->json([
                'status' => false,
                'message'=>'Chuyên Mục Đã Tồn Tại',
            ]);
        }else{
            ChuyenMuc::create($request->all());
            return response()->json([
                'status' => true,
                'message'=>'Thêm Thành Công',
            ]);
        }
    }
    public function data(){
        return response()->json([
            'status' => true,
            'data'=> ChuyenMuc::get(),
        ]);
    }
    public function edit(Request $request){
        $check = ChuyenMuc::where("id",$request->id)->first();
         $request['slug_chuyen_muc'] = Str::slug($request->ten_chuyen_muc);
        if($check){
            $check->update($request->all());
            return response()->json([
                'status' => true,
                'message'=>'Cập Nhật Thành Công',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'=>'Không Tìm Thấy ID',
            ]);
        }
    }
    public function delete($id){
        $check = ChuyenMuc::find($id);
        if($check){
            DanhMuc::where("id_chuyen_muc", $id)->delete();
            $check->delete();
            return response()->json([
                'status' => true,
                'message'=>'Xóa Thành Công',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'=>'Xóa Thất Bại',
            ]);
        }
    }
}
