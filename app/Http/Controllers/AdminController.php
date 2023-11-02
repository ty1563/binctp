<?php

namespace App\Http\Controllers;

use App\Jobs\XacNhanResetAdminJob;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PDO;
use PhpParser\Node\Expr\FuncCall;
use Brian2694\Toastr\Toastr;

class AdminController extends Controller
{
    public function login()
    {
        return view("Admin.Login.login");
    }
    public function index()
    {

        return view('Admin.Admin.index');
    }
    public function add(Request $request)
    {
        if (!$this->check_admin_get("is_master")) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn Không Có Quyền Thêm Admin',
            ]);
        }
        $check = Admin::where('username', $request->username)
            ->orwhere('email', $request->email)
            ->first();
        if ($check) {
            return response()->json([
                'status' => false,
                'message' => 'Tài Khoản Đã Tồn Tại',
            ]);
        } else {
            $request['password'] = bcrypt($request->password);
            Admin::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Thêm Mới Tài Khoản Thành Công',
            ]);
        }
    }
    public function data()
    {
        $data = Admin::select("username", "email", "sdt")->get();
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
    public function change_password(Request $request)
    {
        $check = Admin::where("username", $request->username)
            ->where("email", $request->email)
            ->where("sdt", $request->sdt)
            ->first();
        if ($check) {
            $check->password = bcrypt($request->password_change);
            $check->hash_reset = null;
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Cập Nhật Mật Khẩu Mới Cho Tài Khoản ' . $request->username . ' Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Cập Nhật Thất Bại',
            ]);
        }
    }
    public function sendMail(Request $request)
    {
        $check = Admin::where("username", $request->username)
            ->orwhere("email", $request->email)
            ->orwhere("sdt", $request->sdt)
            ->first();
        if ($check) {
            $data['email'] = $request->email;
            $data['hash_reset'] = random_int(100000, 999999);
            XacNhanResetAdminJob::dispatch($data);
            $check->hash_reset = $data['hash_reset'];
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Gửi Mail Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gửi Mail Thất Bại',
            ]);
        }
    }
    public function change(Request $request)
    {
        $check = Admin::where("username", $request->username)->first();
        if ($check->hash_reset == $request->ma) {
            return response()->json([
                'status' => true,
                'message' => 'Xác Minh Thành Công , Nhập Mật Khẩu Mới'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Mã Xác Nhận Không Đúng',
            ]);
        }
    }
    public function xoa($username)
    {
        if (!$this->check_admin_get("is_master")) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn Không Có Quyền Xóa Admin Khác',
            ]);
        }
        $check = Admin::where("username", $username)->first();
        if ($check) {
            $check->delete();
            return response()->json([
                'status' => true,
                'message' => 'Xóa Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Xóa Thất Bại',
            ]);
        }
    }
    public function checkLogin(Request $request)
    {
        $check = Auth::guard('admin')->attempt([
            'username' => $request->username,
            'password' => $request->password
        ]);
        return response()->json([
            'status' => $check,
        ]);
    }
    public function loggout()
    {
        Auth::guard('admin')->logout();
        toastr()->success('Đã Đăng xuất thành công!');
        return redirect('/admin/login');
    }
}
