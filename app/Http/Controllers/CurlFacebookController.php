<?php

namespace App\Http\Controllers;

use App\Jobs\CurlShareJob;
use Illuminate\Http\Request;

class CurlFacebookController extends Controller
{
    public function index(){
        return view('Client.Curl.Share.curl-share');
    }
    public function curlShare(Request $request)
    {
        $post_id = $request->input('post_id');
        $soLuong = ceil($request->input('soLuong')/3);
        $delay = 30;
        for ($i = 1; $i <= $soLuong; $i++) {
            CurlShareJob::dispatch($post_id)->delay($delay);
            $delay+=30;
        }
        toastr()->success('Đang Tiến Hành Chia Sẽ ');
        return redirect()->route("trang_chu");
    }
}
