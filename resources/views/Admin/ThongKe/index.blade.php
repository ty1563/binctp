@extends('Admin.master')
@section('noi_dung')
@php
    $tongNgay = number_format($data['tong_ngay'], 0, ',', '.') . '₫';
    $tongThang = number_format($data['tong_thang'], 0, ',', '.') . '₫';
@endphp
    <div class="analyse" id="app">
        <div class="sales">
            <div class="status">
                <div class="info">
                    <h3>Doanh Thu Hôm Nay</h3>
                    <h1>{{$tongNgay}}</h1>
                </div>
                <div class="progresss">
                    <svg>
                        <circle cx="38" cy="38" r="36"></circle>
                    </svg>
                    <div class="percentage">
                        @if ($data['phanTramNgay']>=0)
                        <p>+ {{$data['phanTramNgay']}} %</p>
                        @else
                        <p>{{$data['phanTramNgay']}} %</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="visits">
            <div class="status">
                <div class="info">
                    <h3>Doanh Thu Tháng Này</h3>

                    <h1>{{$tongThang}}</h1>
                </div>
                <div class="progresss">
                    <svg>
                        <circle cx="38" cy="38" r="36"></circle>
                    </svg>
                    <div class="percentage">
                        @if ($data['phanTramThang']>=0)
                        <p>+ {{$data['phanTramThang']}} %</p>
                        @else
                        <p> {{$data['phanTramThang']}} %</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="searches">
            <div class="status">
                <div class="info">
                    <h3>Thành Viên</h3>
                    <h1>{{ $data['tong_tv'] }}</h1>
                </div>
                <div class="progresss">
                    <svg>
                        <circle cx="38" cy="38" r="36"></circle>
                    </svg>
                    <div class="percentage">
                        <p>{{ $data['tong_tv'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Analyses -->

    <!-- New Users Section -->
    <div class="new-users">
        <h2>Người Dùng Mới</h2>
        <div class="user-list">
            @php
                $new_user = explode(',', $data['new_user']);
            @endphp
            @foreach ($new_user as $value)
                <div class="user">
                    <img src="/images/profile-2.jpg">
                    <h2>{{ $value }}</h2>
                </div>
            @endforeach
            <div class="user">
                <a href="/admin/khach-hang"><img src="/images/plus.png"></a>
                <h2>Thêm Mới</h2>
            </div>
        </div>
    </div>
    <!-- End of New Users Section -->
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {

            },
            created() {

            },
            methods: {
                chuyenTien(soTien) {
                    const formatter = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    });
                    return formatter.format(soTien);
                },
            },
        });
    </script>
@endsection
