@extends('Admin.master')

@section('noi_dung')
    <div class="row" id="app">
        <form id="formdata" v-on:submit.prevent="add()">
            <div>
                <div class="text-center">
                    <h5>Tùy Chỉnh Page</h5>
                </div>
                <div>
                    <label class="form-label">Chọn Trang</label>
                    <select class="form-control text-darkmod" name="page">
                        <option value="1">Trang Đầu Tiên</option>
                        <option value="1">Trang Thứ Hai</option>
                    </select>
                    <label class="form-label">Chuyên Mục</label>
                    <select class="form-control text-darkmod" name="id_chuyen_muc">
                        <template v-for="(v,k) in listChuyenMuc">
                            <option v-bind:value="v.id">@{{v.ten_chuyen_muc}}</option>
                        </template>
                    </select>
                    <label class="form-label">Tiêu Đề</label>
                    <input class="form-control" type="text" name="title" v-model ="title">
                    <label class="form-label">Mô Tả</label>
                    <input class="form-control" type="text" name="description" v-model ="description">
                    <label class="form-label">Hình Ảnh</label>
                    <div class="input-group">
                        <input id="hinh_anh" class="form-control" type="text" name="hinh_anh" placeholder="Tải Lên Hình Ảnh">
                        <span class="input-group-prepend">
                            <a id="lfm" data-input="hinh_anh" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Chọn Ảnh
                            </a>
                        </span>
                    </div>
                </div>
                <div class="text-end mt-5">
                    <button type="submit" class="btn btn-success">Thêm Mới</button>
                </div>
            </div>
        </form>
        <div class="mt-3">
            <table class="table">
                <tr>
                    <td class="text-center bold-text">Trang</td>
                    <td class="text-center bold-text">Tiêu Đề</td>
                    <td class="text-center bold-text">Mô Tả</td>
                    <td class="text-center bold-text">Hình Ảnh</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-for="(v,k) in listSetting">
                    <td class="text-center bold-text">@{{ v.page }}</td>
                    <td class="text-center">@{{ v.title }}</td>
                    <td class="text-center" style="width: 20%">@{{ v.description }}</td>
                    <td class="text-center" style="width: 10%"> <img :src="v.hinh_anh" class="d-block w-100 h-200" alt="..."></td>
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
                            <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Danh Mục</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <label class="form-label">Chọn Trang</label>
                                <select class="form-control text-darkmod" name="edit.page">
                                    <template v-for="(v,k) in listChuyenMuc">
                                        <option v-bind:value="v.id">@{{v.ten_chuyen_muc}}</option>
                                    </template>
                                </select>
                                <label class="form-label">Tiêu Đề</label>
                                <input class="form-control" type="text" v-model = "edit.title" v-model ="title">
                                <label class="form-label">Mô Tả</label>
                                <input class="form-control" type="text" v-model = "edit.description" v-model ="description">
                                <label class="form-label">Hình Ảnh</label>
                                <div class="input-group">
                                    <input id="deptrai" class="form-control" type="text" v-model = "edit.hinh_anh" placeholder="Tải Lên Hình Ảnh">
                                    <span class="input-group-prepend">
                                        <a id="lfm_edit" data-input="deptrai" data-preview="holder" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Chọn Ảnh
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" data-bs-dismiss="modal"
                                    v-on:click="updateInfo()" class="btn btn-primary">Lưu</button>
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
                listSetting : [],
                listChuyenMuc : [],
                edit : {},
            },
            created() {
                this.load();
            },
            methods: {
                updateInfo(){
                    this.edit.hinh_anh = $("deptrai").val();
                    axios
                        .post('/admin/setting/update', this.edit)
                        .then((res) => {
                         if(res.data.status){
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
                        .post('/admin/setting/add', paramObj)
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
                load(){
                    axios
                        .post('/admin/chuyen-muc/data', 1)
                        .then((res) => {
                         if(res.data.status){
                            this.listChuyenMuc = res.data.data;
                        }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                    axios
                        .post('/admin/setting/data', 1)
                        .then((res) => {
                         if(res.data.status){
                            this.listSetting = res.data.data;
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
