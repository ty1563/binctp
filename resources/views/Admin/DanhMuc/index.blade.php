@extends('Admin.master')
@section('noi_dung')
    <div class="row" id="app">
        <form id="formdata" v-on:submit.prevent="add()">
            <div >
                <div class="text-center">
                    <h5>Thêm Danh Mục</h5>
                </div>
                <div >
                    <label class="form-label">Chuyên Mục</label>
                    <select style="background-color: #ffffff15;color: #7d8da1;"  name="id_chuyen_muc" class="form-control">
                        <template v-for="(v,k) in listChuyenMuc">
                            <option style="background-color: #ffffff15;color: #7d8da1;" v-if="v.status == 1" v-bind:value="v.id">@{{v.ten_chuyen_muc}}</option>
                        </template>
                    </select>
                    <label class="form-label">Tên Danh Mục</label>
                    <input class="form-control" type="text" name="ten_danh_muc" v-model ="ten_danh_muc" placeholder="Tên Danh Mục">
                    <label>Hình Ảnh</label>
                    <div class="input-group">
                        <input id="hinh_anh" class="form-control" type="text" name="hinh_anh" placeholder="Tải Lên Hình Ảnh">
                        <span class="input-group-prepend">
                            <a id="lfm" data-input="hinh_anh" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Chọn Ảnh
                            </a>
                        </span>
                    </div>
                    <label class="form-label">Mô Tả</label>
                    <textarea style="background-color: #ffffff15;color: #7d8da1;" placeholder="Mô Tả" v-model="mo_ta" class="form-control" name="mo_ta" v-model="mo_ta" id="" cols="10" rows="3"></textarea>
                    <label class="form-label">Xếp Hạng</label>
                    <input class="form-control" v-model="xep_hang" placeholder="Xếp Hạng Sẽ Ưu Tiên Số Cao Hơn (1-10)" type="text" name="xep_hang" v-model ="xep_hang">
                </div>
                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-success">Thêm Mới</button>
                </div>
            </div>
        </form>
        <div class="mt-3">
            <table class="table">
                <tr>
                    <td class="text-center bold-text">#</td>
                    <td class="text-center bold-text">Tên Danh Mục</td>
                    <td class="text-center bold-text">Tên Chuyên Mục</td>
                    <td class="text-center bold-text">Mô Tả</td>
                    <td class="text-center bold-text">Hình Ảnh</td>
                    <td class="text-center bold-text">Xếp Hạng</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-for="(v,k) in listDanhMuc"  v-on:click="edit = v" data-bs-toggle="modal"
                data-bs-target="#infoo">
                    <td class="text-center bold-text">@{{ k + 1 }}</td>
                    <td class="text-center">@{{ v.ten_danh_muc }}</td>
                    <td class="text-center">@{{ v.ten_chuyen_muc }}</td>
                    <td class="text-center" style="width: 20%">@{{ v.mo_ta }}</td>
                    <td class="text-center" style="width: 10%"> <img :src="v.hinh_anh" class="d-block w-100 h-200" alt="..."></td>
                    <td class="text-center">@{{ v.xep_hang }}</td>
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
                                <label class="form-label">Chuyên Mục</label>
                                <select v-model="edit.id_chuyen_muc" class="form-control">
                                    <template v-for="(v,k) in listChuyenMuc">
                                        <option v-if="v.status == 1" v-bind:value="v.id">@{{v.ten_chuyen_muc}}</option>
                                    </template>
                                </select>
                                <label class="form-label">Tên Danh Mục</label>
                                <input class="form-control" type="text" v-model="edit.ten_danh_muc"  placeholder="Tên Danh Mục">
                                <label>Hình Ảnh</label>
                                <div class="input-group">
                                    <input id="iloveu" class="form-control" type="text" v-model="edit.hinh_anh" placeholder="Tải Lên Hình Ảnh">
                                    <span class="input-group-prepend">
                                        <a id="lfm_edit" data-input="iloveu" data-preview="iloveu2" class="btn btn-primary">
                                            <i class="fa fa-picture-o"></i> Chọn Ảnh
                                        </a>
                                    </span>
                                </div>
                                <label class="form-label">Mô Tả</label>
                                <textarea placeholder="Mô Tả" class="form-control" v-model="edit.mo_ta" id="" cols="10" rows="3"></textarea>
                                <label class="form-label">Xếp Hạng</label>
                                <input class="form-control" v-model="edit.xep_hang" placeholder="Xếp Hạng Sẽ Ưu Tiên Số Cao Hơn (1-10)" type="text">

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
                listChuyenMuc: [],
                listDanhMuc: [],
                edit : {},
                ten_danh_muc : '',
                mo_ta : '',
                xep_hang : '',
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
                        .post('/admin/danh-muc/add', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.load();
                                this.ten_danh_muc = '';
                                this.mo_ta = '';
                                this.xep_hang = '';
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
                        .post('/admin/danh-muc/data', 1)
                        .then((res) => {
                         if(res.data.status){
                           this.listDanhMuc = res.data.data;
                        } else {

                        }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
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
                updateInfo(){
                    this.edit.hinh_anh = $("#iloveu").val();
                    axios
                        .post('/admin/danh-muc/edit', this.edit)
                        .then((res) => {
                         if(res.data.status){
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
                xoa(id){
                    if(confirm("Khi Xóa Mục Này Thì Sản Phẩm Cũng Sẽ Được Xóa , Bạn Có Chắc Chắn Muốn Xóa?")){
                        axios
                        .post('/admin/danh-muc/delete/'+id, id)
                        .then((res) => {
                         if(res.data.status){
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
