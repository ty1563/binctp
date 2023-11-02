<?php

namespace App\Http\Controllers;

use App\Models\history;
use Illuminate\Http\Request;

class LichSuController extends Controller
{
    public function index(Request $request){
        $key = $request->get('q');
        $data = history::join('khach_hangs','khach_hangs.id','histories.id_khach')
                        ->join('san_phams','san_phams.id','histories.id_san_pham')
                        ->select("khach_hangs.email",'khach_hangs.username','histories.*','san_phams.ten_san_pham')
                        ->where("khach_hangs.username",'like','%'.$key.'%')
                        ->orderBy("histories.created_at",'desc')
                        ->paginate(10);
        $data->appends(['q' => $key]);
        return view('Admin.History.index',compact('data','key'));
    }
}
