<?php

namespace App\Http\Controllers;

use App\Http\Requests\PanelGameCreateRequest;
use App\Models\CustomGame;
use App\Models\PanelGame;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class PanelGameController extends Controller
{
    public function index()
    {
        return view('Admin.GamePanel.index');
    }

    public function deleteAll()
    {
        PanelGame::truncate();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Tất Cả Thành Công',
        ]);
    }
    public function MultiDelete(Request $request)
    {
        $id = $request->all();
        if (empty($id))
            return response()->json([
                'status' => false,
                'message' => 'Bạn Cần Chọn Key Để Xóa',
            ]);
        foreach ($id as $value) {
            PanelGame::find($value)->delete();
        }
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công',
        ]);
    }
    public function delete($id)
    {
        $check = PanelGame::find($id);
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
    public function update(Request $request)
    {
        $check = PanelGame::find($request->id);
        if (!$check) {
            return response()->json([
                'status' => false,
                'message' => 'Có Lỗi Sãy Ra',
            ]);
        } else {
            $check->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Cập Nhật Thành Công',
            ]);
        }
    }
    public function loadSetting()
    {
        $data = CustomGame::first();
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
    public function updateSetting(Request $request){
        DB::table('custom_games')
        ->where('ten_menu', $request->ten_menu)  // Điều kiện xác định bản ghi cần cập nhật
        ->update($request->except('id'));
        return response()->json([
            'status' => true,
            'message'=>'Cập Nhật Thành Công',
        ]);
    }
    public function add(PanelGameCreateRequest $request)
    {
        if ($request->number > 100) {
            return response()->json([
                'status' => false,
                'message' => "Tối Đa 100 Key Mỗi Lần Tạo",
            ]);
        }

        $thoiGian = $request->thoi_gian;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $createdKeys = [];

        for ($i = 0; $i < $request->number; $i++) {
            $panelGame = PanelGame::create([
                'game' => $request->game,
                'user_key' => Str::random(20, $characters),
                'thoi_gian' => $thoiGian,
                'max_devices' => $request->max_devices,
                'nguoi_tao' => Auth::guard("admin")->user()->username,
                'ngay_tao' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);

            $createdKeys[] = $panelGame->user_key;
        }

        if (!empty($createdKeys)) {
            return response()->json([
                'status' => true,
                'message' => "Tạo Mới Thành Công " . count($createdKeys) . " Key",
                'keys' => $createdKeys,
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Có Lỗi Sãy Ra',
        ]);
    }
    public function data(Request $request)
    {
        $data = PanelGame::orderBy("ngay_tao", 'desc')->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
    public function api(Request $request)
    {
        $data = CustomGame::first();
        $validator = Validator::make($request->all(), [
            'user_key' => 'required',
            'serial' => 'required',
            'game' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(collect([
                'status' => false,
                'message' => 'Dữ Liệu Không Chính Xác',
            ]));
        }
        $userKey = $request->input('user_key');
        $devices = $request->input('serial');
        $game    = $request->input('game');
        $check = PanelGame::where("user_key", $userKey)
            ->where("game", $game)
            ->first();
        if (!$check) {
            return response()->json(collect([
                'status' => false,
                'message' => "Key Sai!",
            ]));
        }
        try {
            if ($check->status == -1)
                return response()->json(collect([
                    'status' => false,
                    'message' => 'Key Đã Bị Khóa',
                ]));
            if ($check->ngay_het_han != null) {
                $ngayHetHan = Carbon::parse($check->ngay_het_han, 'Asia/Ho_Chi_Minh');
                if ($ngayHetHan->isPast()) {
                    return response()->json(collect([
                        'status' => false,
                        'message' => 'Key Đã Hết Hạn',
                    ]));
                }
            }
            if ($check->status == 0) { // Chưa Login lần Nào
                $check->devices = $devices;
                $check->ngay_het_han = Carbon::now('Asia/Ho_Chi_Minh')->addHours($check->thoi_gian);
                $check->status = 1;
                $check->max_devices -= 1;
                $check->save();
                return response()->json(collect([
                    'status' => true,
                    'message' => 'Đăng Nhập Thành Công',
                    'data' => $data,
                    'ngay_het_han' => $ngayHetHan,
                ]));
            } else { // Đã Login
                $arrDevices = explode(',', $check->devices);
                if (in_array($devices, $arrDevices)) {
                    return response()->json(collect([
                        'status' => true,
                        'message' => 'Đăng Nhập Thành Công',
                        'data' => $data,
                        'ngay_het_han' => $ngayHetHan,
                    ]));
                } elseif ($check->max_devices != 0) {
                    $check->devices = $check->devices . ',' . $devices;
                    $check->status = 1;
                    $check->max_devices -= 1;
                    $check->save();
                    return response()->json(collect([
                        'status' => true,
                        'message' => 'Đăng Nhập Thành Công',
                        'data' => $data,
                        'ngay_het_han' => $ngayHetHan,
                    ]));
                }
                if (count($arrDevices) >= $check->max_devices)
                    return response()->json([
                        'status' => false,
                        'message' => 'Key Đã Được Đăng Nhập Trên Thiết Bị Khác',
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->json(collect([
                'status' => false,
                'message' => "Đã Sãy Ra Lỗi",
            ]));
        }
    }
}
