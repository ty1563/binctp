<?php

namespace App\Http\Controllers;

use App\Models\history;
use App\Models\KhachHang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThongKeController extends Controller
{
    public function index()
    {
        $thangHienTai = Carbon::now()->month;
        $thangTruoc = Carbon::now()->subMonth()->month;
        $ngayHienTai = Carbon::now()->toDateString();
        $ngayHomQua = Carbon::now()->subDay()->toDateString();

        $tongThangHienTai = history::whereMonth('created_at', $thangHienTai)->sum('gia_ban');
        $tongThangTruoc = history::whereMonth('created_at', $thangTruoc)->sum('gia_ban');
        $tongNgayHienTai = history::whereDate('created_at', $ngayHienTai)->sum('gia_ban');
        $tongNgayHomQua = history::whereDate('created_at', $ngayHomQua)->sum('gia_ban');
        $thanhVien = KhachHang::count();
        $newUsers = KhachHang::orderBy("created_at", 'desc')->take(3)->pluck('username')->toArray();

        $data = [
            'tong_thang' => $tongThangHienTai,
            'tong_ngay' => $tongNgayHienTai,
            'tong_tv' => $thanhVien,
            'new_user' => implode(',', $newUsers),
            'phanTramThang' => ($tongThangTruoc != 0) ? (($tongThangHienTai - $tongThangTruoc) / $tongThangTruoc) * 100 : 0,
            'phanTramNgay' => ($tongNgayHomQua != 0) ? (($tongNgayHienTai - $tongNgayHomQua) / $tongNgayHomQua) * 100 : 0,
        ];

        return view("Admin.ThongKe.index", compact('data'));
    }
}
