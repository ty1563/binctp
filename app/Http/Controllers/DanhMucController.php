<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Str;
class DanhMucController extends Controller
{
    public function index(){
        if($this->check_admin_get('quyen_danh_muc') || $this->check_admin_get('is_master'))
        return view("Admin.DanhMuc.index");
        else {
            toastr()->error("Bạn Không Có Quyền Này");
            return redirect('/admin');
        }

    }
    public function data(){
        $data = DanhMuc::join("chuyen_mucs","danh_mucs.id_chuyen_muc","chuyen_mucs.id")
                        ->select("chuyen_mucs.ten_chuyen_muc","danh_mucs.*")
                        ->get();
        return response()->json([
            'status' => true,
            'data'=> $data,
        ]);
    }
    public function add(Request $request){
        $request['slug_danh_muc'] = Str::slug($request->ten_danh_muc);
        $check = DanhMuc::where("slug_danh_muc",$request->slug_danh_muc)->first();
        if($check){
            return response()->json([
                'status' => false,
                'message'=>'Danh Mục Đã Tồn Tại',
            ]);
        }else{
            DanhMuc::create($request->all());
            return response()->json([
                'status' => true,
                'message'=>'Thêm Mới Thành Công',
            ]);
        }
    }
    public function edit(Request $request){
        $check = DanhMuc::where("id",$request->id)->first();
        $request['slug_danh_muc'] = Str::slug($request->ten_danh_muc);
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
        $check  = DanhMuc::find($id);
        if($check){
            SanPham::where("id_danh_muc",$id)->delete();
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
