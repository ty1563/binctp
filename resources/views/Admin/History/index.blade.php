@extends('Admin.master')
@section('noi_dung')
    <div class="mt-3">
        <form>
            Lọc Người Dùng : <input class="form-control text-center" type="text" name="q"
                value="{{ $key }}" placeholder="Nhập tên người dùng">
        </form>
        <table class="table">
            <tr>
                <td class="text-center bold-text">#</td>
                <td class="text-center bold-text">Username</td>
                <td class="text-center bold-text">Sản Phẩm</td>
                <td class="text-center bold-text">Thời Gian</td>
                <td class="text-center bold-text">Tổng</td>
                <td class="text-center bold-text">Ngày Mua</td>
            </tr>
            @foreach ($data as $key => $value)
            @php
                $tien = number_format($value->gia_ban, 0, ',', '.') . '₫';
            @endphp
            <tr>
                <td class="text-center bold-text">{{ $key + 1}} </td>
                <td class="text-center"> {{ $value->username }} </td>
                <td class="text-center"> {{ $value->ten_san_pham }} </td>
                <td class="text-center" style="width: 20%"> {{ $value->thoi_gian }} </td>
                <td class="text-center" style="width: 20%"> {{ $tien }} </td>
                <td class="text-center">{{ $value->created_at }}</td>
            </tr>
            @endforeach
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                {{ $data->links() }}
            </ul>
        </nav>
    </div>
@endsection
