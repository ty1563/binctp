<?php

namespace App\Http\Controllers;

use App\Http\Requests\PanelGameCreateRequest;
use App\Models\BypassGame;
use App\Models\CustomGame;
use App\Models\PanelGame;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

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
    public function deleteBypass($id){
        $check = BypassGame::find($id);
        try {
            $check->delete();
            return response()->json([
                'status' => true,
                'message'=>'Xóa Thành Công',
                'bypass' => BypassGame::get(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>'Xóa Thất Bại',
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
        $bypass = BypassGame::get();
        $data = CustomGame::first();
        return response()->json([
            'status' => true,
            'data' => $data,
            'bypass'=> $bypass,
        ]);
    }

    public function updateBypass(Request $request)
    {
        $data = $request->all();
        $count = count($data) / 3;
        $totalAdd = 0;
        for ($i = 1; $i < $count + 1; $i++) {
            // Chuyển Thành Dạng 00 00 00 00
            $xoaSpace = str_replace(" ", "", $request['patch' . $i]);
            $themDauCach = str_split($xoaSpace, 2);
            $convertHex = implode(" ", $themDauCach);

            $libNameKey = $request['lib_name' . $i];
            $offsetKey = $request['offset'].$i;
            $patchKey = $convertHex;
            if (!empty($libNameKey) && !empty($offsetKey) && !empty($patchKey)) {
                BypassGame::create([
                    'lib_name' => $libNameKey,
                    'offset' => $offsetKey,
                    'patch' => $convertHex,
                ]);
                $totalAdd += 1;
            }
        }
        if($totalAdd>0){
            $listBypass = BypassGame::get();
            return response()->json([
                'status' => true,
                'message'=>'Cập Nhật Thành Công',
                'bypass' => $listBypass,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'=>'Cập Nhật Thất Bại',
            ]);
        }
    }
    public function status(Request $request){
        $validator = Validator::make($request->all(), [
            'web' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(collect([
                'status' => false,
                'message' => 'error',
            ]));
        }
        $web = $request->input('web');
        if($web!='binctp')
            return response()->json([
                'status' => false,
                'message'=>'Thất Bại',
            ]);
        $data = DB::table('custom_games')
        ->limit(1)
        ->get("tinh_trang");
        if($data[0]->tinh_trang=="1"){
            $Bypass = BypassGame::get();
            return response()->json(collect([
                'status' => true,
                'data' => $Bypass,
                'message' => 'Hoạt Động',
            ]));
        }else{
            return response()->json(collect([
                'status' => true,
                'message' => 'Bảo Trì',
            ]));
        }
    }
    public function updateSetting(Request $request)
    {
        if(Auth::guard("admin")->user()->id_quyen != "is_master"){
            return response()->json([
                'status' => false,
                'message'=>"Chỉ Admin Mới Được Quyền Này",
            ]);
        }
        DB::table('custom_games')
            ->limit(1)
            ->update([
                'ten_menu' => $request->ten_menu,
                'tinh_trang' => $request->tinh_trang,
                'thong_bao' => $request->thong_bao,
                'esp_status' => $request->esp_status,
                'aimbot_status' => $request->aimbot_status,
                'bullet_status' => $request->bullet_status,
                'memory_status' => $request->memory_status
            ]);
        return response()->json([
            'status' => true,
            'message' => 'Cập Nhật Thành Công',
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
    public function search(Request $request)
    {
        $search = PanelGame::where("user_key", "like", "%" . $request->s . "%")->paginate(10);
        if ($request->s === null)
            return response()->json([
                'status' => true,
                'data' => $search,
                'message' => "Vui Lòng Dán Key Trước Khi Tìm Kiếm",
            ]);
        if (empty($search))
            return response()->json([
                'status' => false,
                'message' => 'Không Tìm Thấy',
            ]);
        return response()->json([
            'status' => true,
            'data' => $search,
            'message' => count($search) . " Kết Quả Được Tìm Thấy",
        ]);
    }
    function extractNumbers($input)
    {
        return preg_replace('/[^0-9]/', '', $input);
    }
    public function api(Request $request)
    {
        $data = CustomGame::first();
        $validator = Validator::make($request->all(), [
            'user_key' => 'required',
            'serial' => 'required',
            'game' => 'required',
            'web' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(collect([
                'status' => false,
                'message' => 'Fuckyou',
            ]));
        }
        if (!strstr($request->input("web"), "binctp")) {
            return response()->json(collect([
                'status' => false,
                'message' => 'Sever',
            ]));
        }
        $ngayHetHan = "";
        $userKey = $request->input('user_key');
        $devices = $request->input('serial');
        $game    = $request->input('game');
        $session = $this->extractNumbers($devices);
        $check = PanelGame::where("user_key", $userKey)
            ->where("game", $game)
            ->first();
        if (!$check) {
            return response()->json(collect([
                'status' => false,
                'message' => "incorrect",
            ]));
        }
        try {
            if ($check->status == -1)
                return response()->json(collect([
                    'status' => false,
                    'message' => 'Key Đã Bị Khóa',
                ]));
            if ($check->ngay_het_han != null) {
                $checkHetHan = Carbon::parse($check->ngay_het_han, 'Asia/Ho_Chi_Minh');
                if ($checkHetHan->isPast()) {
                    return response()->json(collect([
                        'status' => false,
                        'message' => 'Key expired',
                    ]));
                }
                $ngayHetHan = $checkHetHan->format('Y-m-d H:i:s');
            }
            if ($check->status == 0) { // Chưa Login lần Nào
                $check->devices = $devices;
                $check->ngay_het_han = Carbon::now('Asia/Ho_Chi_Minh')->addHours($check->thoi_gian);
                $check->status = 1;
                $check->max_devices -= 1;
                $check->save();
                return response()->json(collect([
                    'status' => true,
                    'message' => 'Login Success',
                    'data' => $data,
                    'ngay_het_han' => $ngayHetHan,
                    'session' => $session,
                ]));
            } else { // Đã Login
                $arrDevices = explode(',', $check->devices);
                if (in_array($devices, $arrDevices)) {
                    return response()->json(collect([
                        'status' => true,
                        'message' => 'Login Success',
                        'data' => $data,
                        'ngay_het_han' => $ngayHetHan,
                        'session' => $session,
                    ]));
                }
                if (!in_array($devices, $arrDevices) && $check->max_devices > 0) {
                    $check->devices = $check->devices . ',' . $devices;
                    $check->status = 1;
                    $check->max_devices -= 1;
                    $check->save();
                    return response()->json(collect([
                        'status' => true,
                        'message' => 'Login Success',
                        'data' => $data,
                        'ngay_het_han' => $ngayHetHan,
                        'session' => $session,
                    ]));
                }
                if (count($arrDevices) >= $check->max_devices)
                    return response()->json([
                        'status' => false,
                        'message' => 'Max Devices',
                    ]);
            }
        } catch (\Throwable $th) {
            return response()->json(collect([
                'status' => false,
                'message' => "Connect Fail",
            ]));
        }
    }
}
