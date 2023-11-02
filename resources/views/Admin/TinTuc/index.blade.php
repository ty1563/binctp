@extends('Admin.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="mt-3">
            <form action="/admin/tin-tuc/capNhatTinTuc" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Cập Nhật Báo Mới Nhất</button>
            </form>
            <form class="m-3">
                <b>Tìm Kiếm Tiêu Đề </b><input class="form-control text-center" type="text" name="q"
                    value="{{$search}}" placeholder="Nhập Tiêu Đề Bạn Muốn Tìm Kiếm">
            </form>
            <table class="table">
                <tr>
                    <th class="text-center bold-text">#</th>
                    <th class="text-center bold-text">Tiêu Đề</th>
                    <th class="text-center bold-text">Mô Tả Ngắn</th>
                    <th class="text-center bold-text">Nội Dung</th>
                    <th class="text-center bold-text">Hình Ảnh</th>
                    <th class="text-center bold-text">Liên Kết</th>
                    <th class="text-center bold-text">Ngày Viết</th>
                    <th class="text-center bold-text">Action</th>
                </tr>
                @foreach ($data as $key => $value)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">
                            <textarea class="text-darkmod" name="" id="" cols="20" rows="3">{{ $value->title }}</textarea>
                        </td>
                        <td class="text-center">
                            <textarea class="text-darkmod" name="" id="" cols="20" rows="3">{{ $value->content }}</textarea>
                        </td>
                        <td class="text-center">
                            <textarea class="text-darkmod" name="" id="" cols="20" rows="3">{{ $value->noi_dung }}</textarea>
                        </td>
                        <td class="text-center" style="width: 10%"> <img src="{{ $value->hinh_anh }}"
                                class="d-block w-100 h-200" alt="..."></td>
                        <td class="text-center">
                            <textarea class="text-darkmod" name="" id="" cols="20" rows="3">{{ $value->link }}</textarea>
                        </td>
                        <td class="text-center">
                            <textarea class="text-darkmod" name="" id="" cols="10" rows="3">{{ $value->date }}</textarea>
                        </td>
                        <td class="text-center">
                            <form action="/admin/tin-tuc/delete/{{ $value->id }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Xóa Bỏ</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <nav aria-label="Page navigation" class="mb-4">
            <ul class="pagination justify-content-center">
                {{ $data->links() }}
            </ul>
        </nav>
    </div>
@endsection
@section('js')
    <script>
        var route_prefix = "/laravel-filemanager";
    </script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $("#lfm").filemanager('image', {
            prefix: route_prefix
        });
    </script>
@endsection
