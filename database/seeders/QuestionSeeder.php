<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cau_hois')->insert([
            [
                'cau_hoi'  =>  'Xu TikTok Là Gì?',
                'tra_loi'  =>  'Xu TikTok là đơn vị tiền tệ ảo trên nền tảng TikTok. Người dùng kiếm xu bằng cách tạo và chia sẻ video hấp dẫn, nhận lượt xem và tương tác. Xu được sử dụng để tặng quà trong TikTok, bao gồm biểu tượng, hiệu ứng âm thanh và hình nền. Người dùng có thể nạp xu qua cửa hàng ứng dụng hoặc thanh toán trực tuyến. Xu TikTok không có giá trị ngoài ứng dụng. Nó tạo sự kết nối và tương tác trong cộng đồng TikTok.',
                'xep_hang' =>  1,
            ],
            [
                'cau_hoi'  =>  'Binctp.com Cung Cấp Những Dịch Vụ Gì',
                'tra_loi'  =>  'BinCtp Chuyên Cung Cấp Các Dịch Vụ Như Nạp Xu Giá Rẻ , Mua Bán Và Trao Đổi Xu Trên TikTok Với Giá Ưu Đãi Rẻ Nhất Thị Trường . Binctp Còn Cung Cấp Các Dịch Vụ Đi Kèm Như Mua Bán Các Loại Tài Khoản Chuyên Dùng Để Săn Xu Trên TikTok Và Các Loại Hack Game Mobile Và Trên Pc',
                'xep_hang' => 2,
            ],
        ]);
    }
}
