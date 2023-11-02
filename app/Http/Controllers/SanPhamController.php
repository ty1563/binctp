<?php

namespace App\Http\Controllers;

use App\Http\Requests\SanPhamRequest;
use App\Models\SanPham;
use Illuminate\Http\Request;
class SanPhamController extends Controller
{

    public function index()
    {
        if ($this->check_admin_get('quyen_san_pham') || $this->check_admin_get('is_master'))
            return view("Admin.SanPham.index");
        else {
            toastr()->error("Bạn Không Có Quyền Này");
            return redirect('/admin');
        }
    }
    public function add(SanPhamRequest $request)
    {
        SanPham::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công',
        ]);
    }
    public function data()
    {
        $data = SanPham::join("danh_mucs", "danh_mucs.id", "san_phams.id_danh_muc")
            ->select("danh_mucs.ten_danh_muc", "san_phams.*")
            ->get();
        return response()->json([
            'status' => true,
            'data'  => $data,
        ]);
    }
    public function edit(Request $request)
    {
        $check = SanPham::find($request->id);
        if ($check) {
            $check->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Cập Nhật Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Cập Nhật Thất Bại',
            ]);
        }
    }
    public function delete($id)
    {
        $check = SanPham::find($id);
        if ($check) {
            $check->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xóa Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Không Tìm Thấy',
            ]);
        }
    }
}
