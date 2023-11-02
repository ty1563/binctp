@extends('Client.home_page')
@section('noi_dung')

    <section class="accessory section bd-container" id="sanPham">
        <h2 class="section-title">Danh Sách Đang Bán</h2>
        <div class="accessory__container bd-grid">
            @foreach ($list as $value)
            @if($value->status)
            <div class="accessory__content">
                <img src="{{ $value->hinh_anh }}" alt="" class="accessory__img">
                <h3 class="accessory__title">{{ $value->ten_danh_muc }}</h3>
                <span class="accessory__category">{{ $value->mo_ta }}</span>
                {{-- <span class="accessory__preci">150.000 - 300.000</span> --}}
                <button class="button-85" role="button" onclick="window.location.href='{{ route('danhMuc', ['slug_chuyen_muc' => $value->slug_chuyen_muc, 'slug_danh_muc' => $value->slug_danh_muc]) }}'">
                    Xem Ngay
                  </button>

                {{-- <button class="button-85" role="button"><a style="color: white;" href="{{ route('danhMuc', ['slug_chuyen_muc' => $value->slug_chuyen_muc, 'slug_danh_muc' => $value->slug_danh_muc]) }}">Xem Ngay</a></button> --}}
                {{-- <a href="#" class="button accessory__button"><i class='bx bx-heart'></i></a> --}}
            </div>
            @endif
            @endforeach
        </div>
    </section>
@endsection
