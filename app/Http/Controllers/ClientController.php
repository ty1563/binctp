<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignKhachCheck;
use App\Models\ChuyenMuc;
use App\Models\DanhGiaSanPham;
use App\Models\DanhMuc;
use App\Models\history;
use App\Models\KhachHang;
use App\Models\LichSuNapTien;
use App\Models\Pack;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientController extends Controller
{
    public function view()
    {
        return view('Client.index');
    }
    public function login()
    {
        return view('Client.Login.index');
    }
    public function naptien()
    {
        $data = LichSuNapTien::where("user_id",Auth::guard("khach")->user()->id)->orderBy('created_at','desc')->paginate(5);
        return view('Client.naptien.index',compact('data'));
    }
    public function info()
    {
        return view('Client.info');
    }
    public function checkLogin(Request $request)
    {
        if (Auth::guard('khach')->attempt(['username' => $request->username, 'password' => $request->password]) || Auth::guard('khach')->attempt(['email' => $request->username, 'password' => $request->password])) {
            if (Auth::guard('khach')->user()->status == 1) {
                toastr()->success("Đăng Nhập Thành Công");
                return response()->json([
                    'status' => true,
                    'message' => 'Đăng Nhập Thành Công',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tài Khoản Của Bạn Đã Bị Khóa',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tên Tài Khoản Hoặc Mật Khẩu Không Chính Xác',
            ]);
        }
    }
    public function checkSign(SignKhachCheck $request)
    {
        KhachHang::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email'    => $request->email,
            'coin'     => 0,
            'status'   => 1,
        ]);
        Auth::guard('khach')->attempt([
            'username' => $request->username,
            'password' => $request->password,
            'email'    => $request->email,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Tạo Mới Thành Công , Đang Chuyển Hướng Trang',
        ]);
        return redirect('/');
    }
    public function logout()
    {
        Auth::guard('khach')->logout();
        toastr()->success("Đăng Xuất Thành Công");
        return redirect('/login');
    }
    public function getChuyenMuc($slug_chuyen_muc)
    {
        $list = DanhMuc::join("chuyen_mucs", 'chuyen_mucs.id', 'danh_mucs.id_chuyen_muc')
            ->where('chuyen_mucs.slug_chuyen_muc', $slug_chuyen_muc)
            ->select("danh_mucs.*", 'chuyen_mucs.*')
            ->distinct()
            ->get();
        if (count($list) > 0) {
            return view('Client.gio_hang', compact('list'));
        }
        toastr()->error("Sản Phẩm Hiện Tại Đang Hết Hàng");
        return redirect('/');
    }
    public function getDanhMuc($slug_chuyen_muc, $slug_danh_muc)
    {
        $data = DanhMuc::join("san_phams", "san_phams.id_danh_muc", 'danh_mucs.id')
            ->where("danh_mucs.slug_danh_muc", $slug_danh_muc)
            ->select("danh_mucs.*", "san_phams.id as id_san_pham", "san_phams.*",)
            ->get();
        if (count($data) > 0) {
            return view('Client.product', compact('data', 'slug_chuyen_muc'));
        } else {
            toastr()->error("Hiện Tại Chưa Có Sản Phẩm Nào");
            return redirect('/');
        }
    }
    public function getSP($slug_chuyen_muc, $slug_danh_muc, $id_san_pham)
    {
        $data = SanPham::join("packs", "packs.id_san_pham", "san_phams.id")
            ->where("packs.id_san_pham", $id_san_pham)
            ->where("san_phams.id", $id_san_pham)
            ->select("san_phams.*", 'packs.gia_ban', 'packs.thoi_gian', 'packs.id as id_pack')
            ->get();

        $id_chuyen_muc = ChuyenMuc::where('slug_chuyen_muc', $slug_chuyen_muc)->first()->id;
        $danhMucLienQuan = DanhMuc::where('id_chuyen_muc', $id_chuyen_muc)->get();
        $dsSanPhamLienQuan = [];
        foreach ($danhMucLienQuan as $danhMuc) {
            $sanPham = SanPham::where('id_danh_muc', $danhMuc->id)
                ->where('id', '!=', $id_san_pham)
                ->get();
            $dsSanPhamLienQuan = array_merge($dsSanPhamLienQuan, $sanPham->toArray());
        }
        if (count($data) > 0) {
            return view('Client.list_sp', compact('data', 'slug_chuyen_muc', 'slug_danh_muc', 'dsSanPhamLienQuan'));
        } else {
            toastr()->error("Hiện Tại Chưa Có Sản Phẩm Nào");
            return redirect("/");
        }
    }
    public function Acctiktok($slug_chuyen_muc, $slug_danh_muc, $id_san_pham)
    {
        $data = SanPham::join("packs", "packs.id_san_pham", "san_phams.id")
            ->where("packs.id_san_pham", $id_san_pham)
            ->where("san_phams.id", $id_san_pham)
            ->select("san_phams.*", 'packs.gia_ban', 'packs.thoi_gian', 'packs.id as id_pack')
            ->get();
        $count = Pack::where("id_san_pham",$id_san_pham)->count();
        $id_chuyen_muc = ChuyenMuc::where('slug_chuyen_muc', $slug_chuyen_muc)->first()->id;
        $danhMucLienQuan = DanhMuc::where('id_chuyen_muc', $id_chuyen_muc)->get();
        $dsSanPhamLienQuan = [];
        foreach ($danhMucLienQuan as $danhMuc) {
            $sanPham = SanPham::where('id_danh_muc', $danhMuc->id)
                ->where('id', '!=', $id_san_pham)
                ->get();
            $dsSanPhamLienQuan = array_merge($dsSanPhamLienQuan, $sanPham->toArray());
        }
        if (count($data) > 0) {
            return view('Client.Acc.list_acc', compact('data', 'slug_chuyen_muc', 'slug_danh_muc', 'dsSanPhamLienQuan','count'));
        } else {
            toastr()->error("Hiện Tại Chưa Có Sản Phẩm Nào");
            return redirect("/");
        }
    }
    public function checkout(Request $request)
    {

        $pack = Pack::find($request->id_pack);
        if (Auth::guard('khach')->user()->coin >= $pack->gia_ban) {
            $khach = KhachHang::find(Auth::guard('khach')->user()->id);
            $khach->coin -= $pack->gia_ban;
            $khach->save();
            history::create([
                'id_khach'    => $khach->id,
                'id_san_pham' => $pack->id_san_pham,
                'key'         => $pack->info,
                'thoi_gian'   => $pack->thoi_gian,
                'gia_ban'     => $pack->gia_ban,
                'type'        => 1,
            ]);
            $pack->delete();
            return response()->json([
                'status' => true,
                'message' => 'Mua Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn Không Đủ Tiền Thanh Toán',
            ]);
        }
    }
    public function checkout_tiktok(Request $request)
    {
        if ($request->number < 1) {
            return response()->json([
                'status' => false,
                'message' => 'Số Lượng Không Được Nhỏ Hơn 1',
            ]);
        }
        $pack = Pack::find($request->id_pack);
        $data = Pack::where("id_san_pham", $request->id)->take($request->number)->get();
        $count = Pack::where("id_san_pham", $request->id)->count();
        $total = $pack->gia_ban * $request->number;
        $lost = number_format($total - Auth::guard('khach')->user()->coin, 0, ',', '.') . '₫';
        if ($count < $request->number) {
            return response()->json([
                'status' => false,
                'message' => 'Kho Không Đủ , Hãy Chọn Số Lượng <= ' . $count,
            ]);
        }
        if (Auth::guard('khach')->user()->coin >= $total) {
            $khach = KhachHang::find(Auth::guard('khach')->user()->id);
            $khach->coin -= $total;
            $khach->save();
            $historyData = [];
            $hash = random_int(100000, 999999);
            foreach ($data as $value) {
                $historyData[] = [
                    'id_khach'    => $khach->id,
                    'id_san_pham' => $value->id_san_pham,
                    'key'         => $value->info,
                    'thoi_gian'   => $value->thoi_gian,
                    'gia_ban'     => $value->gia_ban,
                    'type'        => $hash,
                    'created_at'  => now(),
                ];
            }
            history::insert($historyData);
            Pack::whereIn('id', $data->pluck('id'))->delete();
            return response()->json([
                'status' => true,
                'message' => 'Mua Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Không Đủ Tiền Thanh Toán , Cần Thêm : ' . $lost,
            ]);
        }
    }
    public function history(Request $request)
    {
        $search = $request->get('q');
        $history = History::join('san_phams', 'san_phams.id', 'histories.id_san_pham')
            ->where("id_khach", Auth::guard('khach')->user()->id)
            ->where("san_phams.ten_san_pham", 'like', '%' . $search . '%')
            ->select("san_phams.ten_san_pham", 'histories.thoi_gian', 'histories.gia_ban', 'histories.created_at as ngay_mua', 'histories.type')
            ->orderBy("histories.created_at", 'desc')
            ->get();
        $history = $history->unique('type');
        return view('Client.history', compact('history', 'search'));
    }
    public function down($value)
    {
        $check = history::where("type", $value)
            ->where("id_khach", Auth::guard("khach")->user()->id)
            ->select('key')
            ->get();
        $data = [];
        foreach ($check as $result) {
            $data[] = [
                'key' => $result['key'],
            ];
        }
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ]);
    }
}
