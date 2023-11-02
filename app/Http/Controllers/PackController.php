<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackController extends Controller
{
    public function index()
    {
        if ($this->check_admin_get('quyen_key') || $this->check_admin_get('is_master'))
            return view("Admin.Pack.index");
        else {
            toastr()->error("Bạn Không Có Quyền Này");
            return redirect('/admin');
        }
    }
    public function add(Request $request)
    {
        $xoa_space = preg_replace('/[\s\r\n]+/', ',', $request->info);
        $gop_mang = explode(",", $xoa_space);
        $xoa_Lap = array_unique($gop_mang); // Xóa Lặp
        $themMoi = 0;
        if ($request->loai === 'Tk') {
            return $this->add_tk($request, $xoa_Lap);
        }
        $_check = Pack::where("id_san_pham", $request->id_san_pham)
            ->where("thoi_gian", $request->thoi_gian)
            ->first('gia_ban');
        if ($_check) {
            if ($_check->gia_ban != $request->gia_ban) {
                return response()->json([
                    'status' => false,
                    'message' => ' <span style="color:yellow"> Giá Bán Dành Cho Key ' . $request->thoi_gian . ' Giờ Phải Là <br> ' . $_check->gia_ban .' Vnd </span><br>Nếu Muốn Thay Đổi Vui Lòng Xóa Key Hoặc Thay Đổi Giá Bán Cùng Loại' ,
                ]);
            }
        }
        foreach ($xoa_Lap as $value) {
            $check = pack::where("info", $value)->first();
            if (!$check) {
                pack::create([
                    'info'                  => $value,
                    'id_san_pham'           => $request->id_san_pham,
                    'thoi_gian'             => $request->thoi_gian,
                    'loai'                  => $request->loai,
                    'gia_ban'               => $request->gia_ban,
                ]);
                $themMoi += 1;
            }
        }
        if ($themMoi == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Tất Cả Key Bạn Thêm Đã Tồn Tại',
            ]);
        }
        if ($themMoi < count($xoa_Lap)) {
            return response()->json([
                'status' => true,
                'message' => 'Có Key Đã Có Sẵn Trong Kho , Đã Thêm ' . $themMoi . ' Key Thành Công',
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Đã Thêm ' . $themMoi . ' Key Thành Công',
        ]);
    }
    public function add_tk($request, $xoa_Lap)
    {
        $themMoi = 0;
        $check = Pack::where("id_san_pham", $request->id_san_pham)->first('gia_ban');
        if ($request->gia_ban === $check->gia_ban) {
            foreach ($xoa_Lap as $value) {
                $check = pack::where("info", $value)->first();
                if (!$check) {
                    pack::create([
                        'info'                  => $value,
                        'id_san_pham'           => $request->id_san_pham,
                        'thoi_gian'             => '0',
                        'loai'                  => 'Tk',
                        'gia_ban'               => $request->gia_ban,
                    ]);
                    $themMoi += 1;
                }
            }
            if ($themMoi == 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tất Cả Key Bạn Thêm Đã Tồn Tại',
                ]);
            }
            if ($themMoi < count($xoa_Lap)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Có Key Đã Có Sẵn Trong Kho , Đã Thêm ' . $themMoi . ' Key Thành Công',
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'Đã Thêm ' . $themMoi . ' Key Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Giá Bán Tài Khoản Bạn Đang Thêm Phải Là ' . $check->gia_ban,
            ]);
        }
    }
    public function data()
    {
        $data = Pack::join("san_phams", "packs.id_san_pham", "=", "san_phams.id")
            ->select("san_phams.id", "san_phams.ten_san_pham", DB::raw("COUNT(packs.id) as pack_count"))
            ->groupBy("san_phams.id", "san_phams.ten_san_pham")
            ->get();
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
    public function edit($id)
    {
        $data = Pack::join("san_phams", "san_phams.id", "packs.id_san_pham")
            ->where("packs.id_san_pham", $id)
            ->get();
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
    public function search(Request $request)
    {
        $search = pack::where("info", "like", "%" . $request->search . "%")
            ->where("id_san_pham", $request->id)
            ->get();
        if (count($search) == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Không Tìm Thấy',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'data' =>   $search,
                'message' => 'Tìm Thấy',
            ]);
        }
    }
    public function delete($id)
    {
        $xoa = $id;
        $check = Pack::where("info", $id)->first();
        if ($check) {
            $check->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xóa Thành Công',
                'data'  => $xoa,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Xóa Thất Bại',
            ]);
        }
    }
}
