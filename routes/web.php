<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiConTroller;
use App\Http\Controllers\CallbackController;
use App\Http\Controllers\CauHoiController;
use App\Http\Controllers\ChuyenMucController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientSettingController;
use App\Http\Controllers\CurlFacebookController;
use App\Http\Controllers\DanhGiaSanPhamController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\LichSuController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PanelGameController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\ThongTinController;
use App\Http\Controllers\TinTucController;
use App\Models\PanelGame;
use Illuminate\Support\Facades\Route;
//API GAME
Route::post("/game/api",[PanelGameController::class,'api']);
Route::get("/game/api",function(){
    return response()->json([
        'Telegram' => 'T.me/SoiShipperYT',
        'Zalo'=>'zalo.me/0366508231',
        'Phone Number'=>'0366508231',
    ]);
});


Route::group(['prefix' => '/admin'], function () {
    Route::get('/login', [AdminController::class, 'login']);
    Route::post('/login-admin-check', [AdminController::class, 'checkLogin']);
    Route::get('/logout', [AdminController::class, 'loggout']);
});
Route::group(['prefix' => '/admin', 'middleware' => ['adminCheck']], function () {
    Route::group(['prefix' => '/panel-game'], function () {
        Route::get("/", [PanelGameController::class, 'index']);
        Route::post("/add", [PanelGameController::class, 'add']);
        Route::post("/load-setting", [PanelGameController::class, 'loadSetting']);
        Route::post("/updateSetting", [PanelGameController::class, 'updateSetting']);
        Route::post("/updateBypass", [PanelGameController::class, 'updateBypass']);
        Route::post("/data", [PanelGameController::class, 'data']);
        Route::post("/update", [PanelGameController::class, 'update']);
        Route::post("/search", [PanelGameController::class, 'search']);
        Route::post("/delete/{id}", [PanelGameController::class, 'delete']);
        Route::post("/deleteBypass/{id}", [PanelGameController::class, 'deleteBypass']);
        Route::post("/MultiDelete", [PanelGameController::class, 'MultiDelete']);
        Route::post("/deleteAll", [PanelGameController::class, 'deleteAll']);
    });
    Route::group(['prefix' => '/thong-tin'], function () {
        Route::get("/", [ThongTinController::class, 'index']);
        Route::post("/capNhat", [ThongTinController::class, 'capNhat']);
        Route::post("/add", [ThongTinController::class, 'add']);
        Route::post("/data", [ThongTinController::class, 'data']);
        Route::post("/delete/{id}", [ThongTinController::class, 'delete']);
    });
    Route::group(['prefix' => '/setting'], function () {
        Route::get("/", [ClientSettingController::class, 'index']);
        Route::post("/add", [ClientSettingController::class, 'add']);
        Route::post("/data", [ClientSettingController::class, 'data']);
        Route::post('/update', [ClientSettingController::class, 'update']);
    });
    Route::group(['prefix' => '/'], function () {
        Route::get("/admin", [AdminController::class, 'index']);
        Route::post("/add", [AdminController::class, 'add']);
        Route::post("/data", [AdminController::class, 'data']);
        Route::post('/sendMail', [AdminController::class, 'sendMail']);
        Route::post('/change', [AdminController::class, 'change']);
        Route::post('/change_password', [AdminController::class, 'change_password']);
        Route::post('/delete/{username}', [AdminController::class, 'xoa']);
    });
    Route::group(['prefix' => '/lichsu'], function () {
        Route::get("/", [LichSuController::class, 'index']);
    });
    Route::group(['prefix' => '/tin-tuc'], function () {
        Route::get("/", [TinTucController::class, 'admin']);
        Route::post("/capNhatTinTuc",[TinTucController::class,'capNhatTinTuc']);
        Route::post("/delete/{id}", [TinTucController::class, 'delete']);
    });

    Route::group(['prefix' => '/'], function () {
        Route::get("/", [ThongKeController::class, 'index']);
    });
    Route::group(['prefix' => '/question'], function () {
        Route::get("/", [CauHoiController::class, 'index']);
        Route::post("/add", [CauHoiController::class, 'add']);
        Route::post("/data", [CauHoiController::class, 'data']);
        Route::post("/edit", [CauHoiController::class, 'edit']);
        Route::post("/delete/{id}", [CauHoiController::class, 'delete']);
    });
    Route::group(['prefix' => '/khach-hang'], function () {
        Route::get("/", [KhachHangController::class, 'index']);
        Route::post("/data", [KhachHangController::class, 'data']);
        Route::post("/change/{id}", [KhachHangController::class, 'change']);
        Route::post("/search", [KhachHangController::class, 'search']);
        Route::post("/update", [KhachHangController::class, 'update_coin']);
    });
    Route::group(['prefix' => '/chuyen-muc'], function () {
        Route::get("/", [ChuyenMucController::class, 'index']);
        Route::post("/add", [ChuyenMucController::class, 'add']);
        Route::post("/data", [ChuyenMucController::class, 'data']);
        Route::post("/edit", [ChuyenMucController::class, 'edit']);
        Route::post("/delete/{id}", [ChuyenMucController::class, 'delete']);
    });
    Route::group(['prefix' => '/danh-muc'], function () {
        Route::get("/", [DanhMucController::class, 'index']);
        Route::post("/add", [DanhMucController::class, 'add']);
        Route::post("/data", [DanhMucController::class, 'data']);
        Route::post("/edit", [DanhMucController::class, 'edit']);
        Route::post("/delete/{id}", [DanhMucController::class, 'delete']);
    });
    Route::group(['prefix' => '/san-pham'], function () {
        Route::get("/", [SanPhamController::class, 'index']);
        Route::post("/add", [SanPhamController::class, 'add']);
        Route::post("/data", [SanPhamController::class, 'data']);
        Route::post("/edit", [SanPhamController::class, 'edit']);
        Route::post("/delete/{id}", [SanPhamController::class, 'delete']);
    });
    Route::group(['prefix' => '/pack'], function () {
        Route::get("/", [PackController::class, 'index']);
        Route::post("/add", [PackController::class, 'add']);
        Route::post("/data", [PackController::class, 'data']);
        Route::post("/edit/{id}", [PackController::class, 'edit']);
        Route::post("/search", [PackController::class, 'search']);
        Route::post("/delete/{info}", [PackController::class, 'delete']);
    });
});
Route::get('/xac-minh-email/{hash_active}',[AccountController::class,'confirmEMail']);
Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
//Trang Chủ
Route::get('/', [ClientController::class, 'view'])->name('trang_chu');

// Tin Tức
Route::get('/tin-tuc',[TinTucController::class,'index']);

// info
Route::get("/info", [ClientController::class, 'info'])->middleware('khachCheck');;

// Lịch Sử
Route::get("/history", [ClientController::class, 'history'])->middleware('khachCheck');;

// Auth
Route::get('/login', [ClientController::class, 'login'])->name("login");
Route::get('/logout', [ClientController::class, 'logout']);
Route::get("/recover",[AccountController::class,'recover']);

// Nạp Tiền
Route::get('/naptien', [ClientController::class, 'naptien'])->middleware('khachCheck');
Route::post('/autoTheCao',[ApiConTroller::class,'autoTheCao'])->middleware('khachCheck');
Route::get('/autoBank',[ApiConTroller::class,'autoBank'])->name('autoBank');
Route::get('/autoCongTien',[ApiConTroller::class,'autoCongTien']);
Route::get('/callback-thecao', [CallbackController::class,'callBackTheCao'])->name('thecao');

//Curl
// Route::post("/curl-share",[CurlFacebookController::class,'curlShare'])->name('curl-share');
// Route::get("/curl-share",[CurlFacebookController::class,'index']);


Route::post("/checkout/tiktok", [ClientController::class, 'checkout_tiktok']);
Route::post("/checkout", [ClientController::class, 'checkout']);
Route::post('/login-khach-check', [ClientController::class, 'checkLogin']);
Route::post('/sign-khach-check', [ClientController::class, 'checkSign']);
Route::post('/sendMailRecover',[AccountController::class,'sendMailChange']);
Route::post('/checkMailRecover',[AccountController::class,'confirmChangeMail']);
Route::post('/changePassword',[AccountController::class,'changePassword']);
Route::post('/history/download/{value}', [ClientController::class, 'down']);
Route::post('/sendMailConfirmEmail',[AccountController::class,'sendMail']);
Route::post('/sendMailChangeEmail',[AccountController::class,'sendMailChange']);
Route::post('/confirmChangeMail',[AccountController::class,'confirmChangeMail']);
Route::post('/changeUsername',[AccountController::class,'changeUsername']);
Route::post('/changeEmail',[AccountController::class,'changeEmail']);
Route::post('/recoverPassowrd',[AccountController::class,'recoverPassowrd']);
Route::post('/rate',[RateController::class,'rate']);
Route::post('/guiDanhGia',[DanhGiaSanPhamController::class,'guiDanhGia'])->middleware('khachCheck');
Route::post('/danhGiaData',[DanhGiaSanPhamController::class,'danhGiaData'])->middleware('khachCheck');
Route::post('/removeDanhGia/{id}',[DanhGiaSanPhamController::class,'removeDanhGia'])->middleware('khachCheck');

///
Route::get('/pay/{slug_chuyen_muc}', [ClientController::class, 'getChuyenMuc'])->name("chuyenMuc")->middleware('khachCheck');
Route::get('/pay/{slug_chuyen_muc}/{slug_danh_muc}', [ClientController::class, 'getDanhMuc'])->name("danhMuc")->middleware('khachCheck');
Route::get('/pay/{slug_chuyen_muc}/{slug_danh_muc}/{id_san_pham}', [ClientController::class, 'getSP'])->name("sanPham")->middleware('khachCheck');
Route::get('/tiktok/{slug_chuyen_muc}/{slug_danh_muc}/{id_san_pham}', [ClientController::class, 'Acctiktok'])->name("tiktok")->middleware('khachCheck');
