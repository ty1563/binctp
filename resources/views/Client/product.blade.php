@extends('Client.home_page')
@section('noi_dung')
    <section class="accessory section bd-container" id="sanPham">
        <h2 class="section-title">Danh Sách {{ $data[0]->ten_danh_muc }} Đang Bán</h2>

        <div class="accessory__container bd-grid">
            @foreach ($data as $value)
                <div class="accessory__content">
                    <img src="{{ $value->hinh_anh }}" alt="" class="accessory__img">
                    <h3 class="accessory__title">{{ $value->ten_san_pham }}</h3>
                    @php
                        $mota = str_replace('@', ' ', $value->mo_ta);
                    @endphp
                    <span class="accessory__category">{{ $mota }}</span>
                    {{-- <span class="accessory__preci">{{$value->mo_ta}}</span> --}}
                    {{-- <button class="button-85" role="button">Xem Ngay</button> --}}
                    @if ($slug_chuyen_muc == 'tai-khoan-tiktok')
                        <button class="button-85" role="button"
                            onclick="window.location.href='/tiktok/{{ $slug_chuyen_muc }}/{{ $value->slug_danh_muc }}/{{ $value->id_san_pham }}'">
                            Xem Ngay
                        </button>
                    @else
                        <button class="button-85" role="button"
                            onclick="window.location.href='{{ route('sanPham', ['slug_chuyen_muc' => $slug_chuyen_muc, 'slug_danh_muc' => $value->slug_danh_muc, 'id_san_pham' => $value->id_san_pham]) }}'">
                            Xem Ngay
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection
@section('js')
@endsection
