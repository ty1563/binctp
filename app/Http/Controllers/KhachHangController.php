<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("Admin.KhachHang.index");
    }
    public function data()
    {
        $data = KhachHang::orderBy("created_at", 'desc')->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
    public function change($id)
    {
        $check = KhachHang::find($id);
        if ($check) {
            $check->status = !$check->status;
            $check->save();
            return response()->json([
                'status' => true,
                'message' => 'Chuyển Trạng Thái Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Chuyển Trạng Thái Thất Bại',
            ]);
        }
    }
    public function search(Request $request)
    {
        $search = KhachHang::where("username", "like","%".$request->searchKey."%")->orderBy('created_at','desc')->get();
        if(count($search)>0){
            return response()->json([
                'status' => true,
                'data' => $search,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message'=>'Không Tìm Thấy',
            ]);
        }
    }
    public function update_coin(Request $request){
        $check = KhachHang::find($request->id);
        $check->coin = $request->coin;
        $check->save();
        $new = number_format($request->coin ,0, ',', '.') . '₫';
        return response()->json([
            'status' => true,
            'message'=>'Thành Công Số Dư User '. $check->username . ' Là '. $new,
        ]);
    }
}
