<?php

namespace App\Http\Controllers;

use App\Models\CauHoi;
use Illuminate\Http\Request;

class CauHoiController extends Controller
{
    public function index()
    {
        return view('Admin.Question.index');
    }
    public function add(Request $request)
    {
        $check = CauHoi::where('xep_hang',$request->xep_hang)->first();
        if($check){
            return response()->json([
                'status' => false,
                'message'=>'Xếp Hạng '. $check->xep_hang . ' Đã Tồn Tại',
            ]);
        }
        $count = CauHoi::count();
        if ($count < 10) {
            CauHoi::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Thêm Mới Thành Công',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Chỉ Được Thêm Tối Đa 10 Câu Hỏi Và Trả Lời',
            ]);
        }
    }
    public function data()
    {
        return response()->json([
            'status' => true,
            'data' => CauHoi::orderBy('xep_hang', 'asc')->get(),
        ]);
    }
    public function delete(CauHoi $id){
        if($id->delete()){
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
