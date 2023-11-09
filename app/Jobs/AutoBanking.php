<?php

namespace App\Jobs;

use App\Models\Bank;
use App\Models\KhachHang;
use App\Models\LichSuNapTien;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class AutoBanking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    public function handle(): void
    {
        try {
            $mutexKey = 'autoBankMutex'; // Khóa mutex

            if (Cache::add($mutexKey, true, 30)) {
                Http::get(route('autoBank'));

                $job = (new AutoBanking())->delay(60);
                dispatch($job)->onQueue($this->queue);
            } else {
                // Log::channel('nganHang')->info('Công việc đang được thực thi.'); // Công việc đã được khởi chạy
            }
        } catch (\Throwable $th) {
            // Log::channel('nganHang')->info('Không Thể Truy Cập');
        } finally {
            Cache::forget($mutexKey); // Xóa mutex sau khi công việc hoàn thành
        }
    }
}
