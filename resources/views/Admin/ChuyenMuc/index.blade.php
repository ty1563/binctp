@extends('Admin.master')

@section('noi_dung')
    <div class="row" id="app">
        <form id="formdata" v-on:submit.prevent="add()">
            <div>
                <div class="text-center">
                    <h5>Thêm Chuyên Mục</h5>
                </div>
                <div>
                    <label class="form-label">Tên Chuyên Mục</label>
                    <input class="form-control" type="text" name="ten_chuyen_muc" v-model="ten_chuyen_muc">
                    <label class="form-label">Loại</label>
                    <select class="form-control" name="loai" id="loai">
                        <option value="game">Game</option>
                        <option value="tiktok">TikTok</option>
                        <option value="khac">Khác</option>
                    </select>
                    <label>Logo</label>
                    <div class="input-group">
                        <input id="logo" class="form-control" type="text" name="logo"
                            placeholder="Tải Lên Hình Ảnh">
                        <span class="input-group-prepend">
                            <a id="lfm" data-input="logo" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Chọn Ảnh
                            </a>
                        </span>
                    </div>
                    <label class="form-label">Tình Trạng</label>
                    <select class="form-control text-darkmod" name="status">
                        <option value="1" class="active">Mở</option>
                        <option value="0">Đóng</option>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Thêm Mới</button>
                </div>
            </div>
        </form>
        <div class="mt-3">
            <table class="table">
                <tr>
                    <td class="text-center bold-text">#</td>
                    <td class="text-center bold-text">Tên Chuyên Mục</td>
                    <td class="text-center bold-text">Tình Trạng</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-for="(v,k) in listChuyenMuc" v-on:click="edit = v" data-bs-toggle="modal" data-bs-target="#infoo">
                    <td class="text-center bold-text">@{{ k + 1 }}</td>
                    <td class="text-center">@{{ v.ten_chuyen_muc }}</td>
                    <td v-if="v.status == 1" class="text-center">Mở</td>
                    <td v-else class="text-center">Đóng</td>
                    <td class="text-center">
                        <button v-on:click="edit = v" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#infoo">
                            Cập Nhật
                        </button>
                        <button v-on:click="xoa(v.id)" class="btn btn-danger">Xóa Bỏ</button>
                    </td>
                </tr>
                <div class="modal fade" id="infoo" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Chuyên Mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="form-label">Tên Chuyên Mục</label>
                                <input class="form-control" type="text" v-model="edit.ten_chuyen_muc">
                                <label class="form-label">Tình Trạng</label>
                                <select class="form-control" v-model="edit.status">
                                    <option value="1" class="active">Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" data-bs-dismiss="modal" v-on:click="updateInfo()"
                                    class="btn btn-primary">Lưu</button>
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
                listChuyenMuc: [],
                edit: {},
                ten_chuyen_muc: '',
            },
            created() {
                this.load();
            },
            methods: {
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
                        .post('/admin/chuyen-muc/add', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.load();
                                this.ten_chuyen_muc = '';
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
                        .post('/admin/chuyen-muc/data', 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.listChuyenMuc = res.data.data;
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                updateInfo() {
                    axios
                        .post('/admin/chuyen-muc/edit', this.edit)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
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
                xoa(id) {
                    if (confirm(
                            "Xóa Mục Này Sẽ Xóa Hết Tất Cả Các Danh Mục, Sản Phẩm Liên Quan . Bạn Chắc Chắn Muốn Xóa?"
                        )) {
                        axios
                            .post('/admin/chuyen-muc/delete/' + id, id)
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
                    }
                }
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
