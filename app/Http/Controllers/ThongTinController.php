<?php

namespace App\Http\Controllers;

use App\Models\ThongTin;
use Illuminate\Http\Request;

class ThongTinController extends Controller
{
    public function index()
    {
        return view("Admin.ThongTin.index");
    }
    public function capNhat(Request $request){
        $data = $request->all();
        $data = array_filter($data, function($value) {
            return !is_null($value);
        });
        $titles = [];
        $links = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'tieuDe') === 0) {
                $index = substr($key, strlen('tieuDe'));
                $titles[$index] = $value;
            } elseif (strpos($key, 'linkDong') === 0) {
                $index = substr($key, strlen('linkDong'));
                $links[$index] = $value;
            }
        }
        $_moTa = '';
        foreach ($titles as $index => $title) {
            $link = isset($links[$index]) ? $links[$index] : null;
            $_moTa .= $title . '|' . $link . ',';
        }
        $request['mo_ta'] = rtrim($_moTa, ',');
        ThongTin::first()->update($request->all());
        return response()->json([
            'status' => true,
            'message'=>'Cập Nhật Thành Công',
        ]);
    }
    public function add(Request $request)
    {
        $check = ThongTin::count();
        if ($check > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Chỉ Được Thêm Tối Đa 1 Người',
            ]);
        }
        $data = $request->all();
        $titles = [];
        $links = [];
        foreach ($data as $key => $value) {
            if (strpos($key, 'tieuDe') === 0) {
                $index = substr($key, strlen('tieuDe'));
                $titles[$index] = $value;
            } elseif (strpos($key, 'linkDong') === 0) {
                $index = substr($key, strlen('linkDong'));
                $links[$index] = $value;
            }
        }
        $_moTa = '';
        foreach ($titles as $index => $title) {
            $link = isset($links[$index]) ? $links[$index] : null;
            $_moTa .= $title . '|' . $link . ',';
        }
        $request['mo_ta'] = rtrim($_moTa, ',');
        ThongTin::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm Thành Công',
        ]);
    }
    public function data()
    {
        return response()->json([
            'status' => true,
            'data' => ThongTin::get(),
        ]);
    }
    public function delete($id)
    {
        ThongTin::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa Thành Công',
        ]);
    }
}
