<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeMailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Jobs\ConfirmEmailJob;
use App\Jobs\XacNhanResetAdminJob;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class AccountController extends Controller
{
    public function recover()
    {
        return view('Client.Login.recover');
    }
    public function sendMail(Request $request)
    {
        $check = KhachHang::where("email", $request->email)->first();
        if ($check) {
            $data['email'] = $request->email;
            $data['hash_active'] = Str::uuid();
            ConfirmEmailJob::dispatch($data);
            $check->hash_active = $data['hash_active'];
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Gửi Mail Xác Nhận Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gửi Mail Thất Bại',
            ]);
        }
    }
    public function confirmEMail($hash_active)
    {
        $check = KhachHang::where("hash_active", $hash_active)->first();
        if ($check) {
            $check->active = 1;
            $check->hash_active = null;
            $check->save();
            Toastr()->success("Đã Xác Minh Mail Thành Công");
            return redirect()->route('trang_chu');
        } else {
            Toastr()->error("Liên Kết Đã Bị Hỏng ! Xác Minh Không Thành Công");
            return redirect()->route('trang_chu');
        }
    }
    public function changeUsername(Request $request)
    {
        if ($request->old === $request->username) {
            return response()->json([
                'status' => false,
                'message' => 'Không Có Sự Thay Đổi',
            ]);
        }
        $check = KhachHang::where('username', $request->old)->first();
        $checkNew = KhachHang::where('username', $request->username)->first();
        if ($check && !$checkNew) {
            $check->username = $request->username;
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Thay Đổi Thành Công',
                'new'    => $request->username,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Username Đã Tồn Tại',
            ]);
        }
    }
    public function sendMailChange(Request $request)
    {
        $check = KhachHang::where("email", $request->email)->first();
        if ($check) {
            if ($check->active != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email Bạn Chưa Được Kích Hoạt',
                ]);
            }
            $data['email'] = $request->email;
            $data['hash_reset'] = random_int(100000, 999999);
            XacNhanResetAdminJob::dispatch($data);
            $check->hash_reset = $data['hash_reset'];
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Gửi Mail Thành Công , Vui Lòng Nhập Mã Xác Nhận Bên Dưới',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email Không Tồn Tại',
            ]);
        }
    }
    public function confirmChangeMail(Request $request)
    {
        $check = KhachHang::where("email", $request->email)
            ->where("hash_reset", $request->hash_reset)
            ->first();
        if (!$check) {
            return response()->json([
                'status' => false,
                'message' => 'Mã Xác Nhận Không Chính Xác',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Xác Minh Thành Công',
            ]);
        }
    }
    public function changeEmail(ChangeMailRequest $request)
    {
        if ($request->old === $request->new) {
            return response()->json([
                'status' => false,
                'message' => 'Không Có Sự Thay Đổi',
            ]);
        }
        $checkNew = KhachHang::where('email', $request->new)->first();
        $check = KhachHang::where('email', $request->old)->first();
        if ($check && !$checkNew) {
            $check->email = $request->new;
            $check->hash_reset = null;
            $check->active = 0;
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Thay Đổi Thành Công',
                'new'    => $request->new,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Username Đã Tồn Tại',
            ]);
        }
    }
    public function changePassword(Request $request)
    {
        $check = KhachHang::where('email', $request->email)
            ->where("hash_reset", $request->hash_reset)
            ->first();
        if ($check->password === $request->password) {
            return response()->json([
                'status' => false,
                'message' => 'Không Được Đặt Giống Mật Khẩu Cũ',
            ]);
        }
        if ($check) {
            $check->password =  bcrypt($request->password);
            $check->hash_reset = null;
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Thay Đổi Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Đã Có Lỗi Sảy Ra',
            ]);
        }
    }
    public function recoverPassowrd(ChangePasswordRequest $request)
    {
        $check =  KhachHang::where("username", $request->username)->first();
        if ($check && Hash::check($request->password, $check->password)) {
            $check->password = bcrypt($request->newPassword);
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Thay Đổi Mật Khẩu Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Mật Khẩu Cũ Không Chính Xác',
            ]);
        }
    }
}
