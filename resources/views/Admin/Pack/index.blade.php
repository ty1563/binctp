@extends('Admin.master')

@section('noi_dung')
    <div class="row" id="app">
        <form id="formdata" v-on:submit.prevent="add()">
            <div>
                <div class="text-center">
                    <h5>Quản Lý Danh Sách Đang Bán</h5>
                </div>
                <div>
                    <label class="form-label mt-1">Chọn Sản phẩm</label>
                    <select class="form-control text-darkmod" name="id_san_pham">
                        <template v-for="(v,k) in listSanPham">
                            <option v-bind:value="v.id">@{{ v.ten_san_pham }}</option>
                        </template>
                    </select>
                    <label class="form-label mt-1">Chọn Thời Gian</label>
                    <select class="form-control text-darkmod" name="thoi_gian">
                        <option value="0" class="active">Không(Đối Với Tài Khoản)</option>
                        <option value="24">24 Giờ (Đối Với Key)</option>
                        <option value="180">180 Giờ (Đối Với Key)</option>
                        <option value="720">720 Giờ (Đối Với Key)</option>
                    </select>
                    <label class="form-label mt-1 text-danger">Loại (* Lưu Ý Chọn Loại Tài Khoản)</label>
                    <select class="form-control text-darkmod" name="loai">
                        <option value="key" class="active">Key Hack</option>
                        <option value="Xu">Xu TikTok</option>
                        <option value="Tk">Tài Khoản</option>
                        <option value="Khac">Khác</option>
                    </select>
                    <label class="form-label mt-1">Danh Sách</label>
                    <textarea class="form-control text-darkmod" name="info" cols="10" rows="3"
                        placeholder="Mỗi Key Tương Ứng Mỗi Dòng"></textarea>
                    <label class="form-label mt-1">Giá Bán</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">VNĐ</span>
                        <input type="text" name="gia_ban" class="form-control text-darkmod">
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Thêm Mới</button>
                </div>
            </div>
        </form>
        <div class="mt-3">
            <table class="table">
                <tr>
                    <td class="text-center bold-text">#</td>
                    <td class="text-center bold-text">Tên Sản Phẩm</td>
                    <td class="text-center bold-text">Tổng Key Đang Treo</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-for="(v,k) in listCountPack" v-on:click="edit(v.id)" data-bs-toggle="modal" data-bs-target="#infoo">
                    <td class="text-center bold-text">@{{ k + 1 }}</td>
                    <td class="text-center">@{{ v.ten_san_pham }}</td>
                    <td class="text-center">@{{ v.pack_count }}</td>
                    <td class="text-center">
                        <button v-on:click="edit(v.id)" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#infoo">
                            Chi Tiết
                        </button>

                    </td>
                </tr>

                <div class="modal fade" id="infoo" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-darkmod" id="exampleModalLabel">Chi Tiết</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="search" v-model="searchKey" v-on:keyup="timkiemkey()" class="form-control"
                                    placeholder="Gõ Để Tìm Kiếm" />
                                <template>
                                    <table v-if="searchKey == null" class="table">
                                        <tr>
                                            <td class="text-center bold-text">#</td>
                                            <td class="text-center bold-text">Key</td>
                                            <td class="text-center bold-text">Time/Price</td>
                                            <td class="text-center bold-text">Action</td>
                                        </tr>
                                        <tr v-for="(v,k) in listChiTiet" v-on:click="xoa(v.info)">
                                            <td class="text-center bold-text">@{{ k + 1 }}</td>
                                            <td class="text-center bold-text">@{{ v.info }}</td>
                                            <td class="text-center bold-text">@{{ v.thoi_gian }} h /
                                                @{{ chuyenDoiTien(v.gia_ban) }}</td>
                                            <td class="text-center bold-text">
                                                <button v-on:click="xoa(v.info)" class="btn btn-danger">Xóa</button>
                                            </td>
                                        </tr>
                                    </table>
                                </template>
                                {{-- tìm kiếm có --}}
                                <template v-if="searchKey != null">
                                    <table class="table">
                                        <tr>
                                            <td class="text-center bold-text">#</td>
                                            <td class="text-center bold-text">Key</td>
                                            <td class="text-center bold-text">Thời Gian</td>
                                            <td class="text-center bold-text">Action</td>
                                        </tr>
                                        <tr v-for="(v,k) in listSearch" v-on:click="xoa(v.info)">
                                            <td class="text-center bold-text">@{{ k + 1 }}</td>
                                            <td class="text-center bold-text">@{{ v.info }}</td>
                                            <td class="text-center bold-text">@{{ v.thoi_gian }} Giờ</td>
                                            <td class="text-center bold-text">
                                                <button v-on:click="xoa(v.info)" class="btn btn-danger">Xóa</button>
                                            </td>
                                        </tr>
                                    </table>
                                </template>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                listCountPack: [],
                listSanPham: [],
                listChiTiet: [],
                searchKey: null,
                id_key: null,
                listSearch: [],
            },
            created() {
                this.load();
            },
            methods: {
                chuyenDoiTien(gia) {
                    const formatter = new Intl.NumberFormat("vi-VN", {
                        style: "currency",
                        currency: "VND"
                    });
                    return formatter.format(gia);
                },
                add() {
                    var paramObj = {};
                    $.each($('#formdata').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    axios
                        .post('/admin/pack/add', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.load();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                load() {
                    axios
                        .post('/admin/san-pham/data', 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.listSanPham = res.data.data;
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                    axios
                        .post('/admin/pack/data', 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.listCountPack = res.data.data;
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                edit(id) {
                    axios
                        .post('/admin/pack/edit/' + id, id)
                        .then((res) => {
                            if (res.data.status) {
                                this.listChiTiet = res.data.data;
                                this.id_key = id;
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                timkiemkey() {
                    var search = {
                        'search': this.searchKey,
                        'id': this.id_key,
                    };
                    if (this.searchKey != null) {
                        axios
                            .post('/admin/pack/search', search)
                            .then((res) => {
                                if (res.data.status) {
                                    this.listSearch = res.data.data;
                                } else {
                                    toastr.error(res.data.message);
                                    this.searchKey = null;
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    }
                },
                xoa(info) {
                    if (confirm("Bạn Có Chắc Chắn Muốn Xóa Key Này Không ?")) {
                        axios
                            .post('/admin/pack/delete/' + info, info)
                            .then((res) => {
                                if (res.data.status) {
                                    // Nếu info không khớp, phần tử sẽ được giữ lại trong mảng. Nếu info khớp, phần tử sẽ bị loại bỏ khỏi mảng.
                                    // ==: Toán tử so sánh bằng, kiểm tra xem hai giá trị có bằng nhau sau khi thực hiện ép kiểu dữ liệu (chuyển đổi một kiểu sang kiểu khác nếu cần).
                                    // ===: Toán tử so sánh cùng giá trị và cùng kiểu dữ liệu, kiểm tra xem hai giá trị có bằng nhau mà không thực hiện ép kiểu dữ liệu. Các kiểu dữ liệu cũng phải khớp nhau.
                                    // !=: Toán tử so sánh khác, kiểm tra xem hai giá trị có khác nhau sau khi thực hiện ép kiểu dữ liệu.
                                    // !==: Toán tử so sánh khác nhau một cách nghiêm ngặt, kiểm tra xem hai giá trị có khác nhau mà không thực hiện ép kiểu dữ liệu hoặc có các kiểu dữ liệu khác nhau.
                                    this.listSearch = this.listSearch.filter(value => value.info !== res.data
                                        .data);
                                    this.listChiTiet = this.listChiTiet.filter(value => value.info !== res.data
                                        .data);
                                    toastr.success(res.data.message);
                                    this.load();
                                } else {
                                    toastr.error(res.data.message);
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    }
                },
            },
        });
    </script>
    <script>
        var route_prefix = "/laravel-filemanager";
    </script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $("#lfm").filemanager('image', {
            prefix: route_prefix
        });
        $("#lfm_edit").filemanager('image', {
            prefix: route_prefix
        });
    </script>
@endsection
