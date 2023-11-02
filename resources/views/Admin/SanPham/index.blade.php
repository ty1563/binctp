@extends('Admin.master')

@section('noi_dung')
    <div class="row" id="app">
        <form id="formdata" v-on:submit.prevent="add()">
            <div>
                <div class="text-center">
                    <h5>Thêm Sản Phẩm</h5>
                </div>
                <div>
                    <label class="form-label">Danh Mục</label>
                    <select style="background-color: #ffffff15;color: #7d8da1;" name="id_danh_muc" class="form-control">
                        <template v-for="(v,k) in listDanhMuc">
                            <option style="background-color: #ffffff15;color: #7d8da1;" v-bind:value="v.id">
                                @{{ v.ten_danh_muc }}</option>
                        </template>
                    </select>
                    <label class="form-label">Tên Sản Phẩm</label>
                    <input class="form-control" type="text" name="ten_san_pham" v-model="ten_san_pham"
                        placeholder="Tên Sản Phẩm">
                    <label>Hình Ảnh</label>
                    <div class="input-group">
                        <input id="hinh_anh" class="form-control" type="text" name="hinh_anh"
                            placeholder="Tải Lên Hình Ảnh">
                        <span class="input-group-prepend">
                            <a id="lfm" data-input="hinh_anh" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Chọn Ảnh
                            </a>
                        </span>
                    </div>
                    <label class="form-label">Mô Tả Chức Năng (Mỗi Dòng Cách Nhau Bởi Dấu @)</label>
                    <textarea style="background-color: #ffffff15;color: #7d8da1;" placeholder="Mỗi Dòng Hiển Thị Cách Nhau @ VD : An Toàn 100%@Bảo hành 1-1...." v-model="mo_ta" class="form-control"
                        name="mo_ta" v-model="mo_ta" id="" cols="10" rows="3"></textarea>
                    <label class="form-label">Link Tải</label>
                    <input class="form-control" v-model="link1" placeholder="Link Tải" type="text" name="link1">
                    <label class="form-label">Link Video</label>
                    <input class="form-control" v-model="link2" placeholder="Dự Phòng" type="text" name="link2">
                    <label class="form-label">Tình Trạng</label>
                    <select style="background-color: #ffffff15;color: #7d8da1;" name="status" class="form-control">
                        <option style="background-color: #ffffff15;color: #7d8da1;" class="active" value="1">Hoạt Động
                        </option>
                        <option style="background-color: #ffffff15;color: #7d8da1;" value="0">Bảo Trì</option>
                    </select>
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
                    <td class="text-center bold-text">Tên Sản Phẩm</td>
                    <td class="text-center bold-text">Hình Ảnh</td>
                    <td class="text-center bold-text">Tình Trạng</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-if="view<767" v-for="(v,k) in listSanPham" v-on:click="edit = v" data-bs-toggle="modal"
                data-bs-target="#btn-cap-nhat">
                    <td class="text-center bold-text">@{{ k + 1 }}</td>
                    <td class="text-center">@{{ v.ten_danh_muc }}</td>
                    <td class="text-center">@{{ v.ten_san_pham }}</td>
                    <td class="text-center" style="width: 10%"> <img :src="v.hinh_anh" class="d-block w-100 h-200"
                            alt="..."></td>
                    <td class="text-center text-primary" v-if="v.status ==1">Hoạt Động</td>
                    <td class="text-center text-danger" v-else>Bảo Trì</td>
                    <td class="text-center">
                        <button v-on:click="edit = v" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#btn-cap-nhat">
                            Update
                        </button>
                        <button v-on:click="xoa(v.id)" class="btn btn-danger">Xóa</button>
                    </td>
                </tr>
                <tr v-if="view>767" v-for="(v,k) in listSanPham">
                    <td class="text-center bold-text">@{{ k + 1 }}</td>
                    <td class="text-center">@{{ v.ten_danh_muc }}</td>
                    <td class="text-center">@{{ v.ten_san_pham }}</td>
                    <td class="text-center" style="width: 10%"> <img :src="v.hinh_anh" class="d-block w-100 h-200"
                            alt="..."></td>
                    <td class="text-center text-primary" v-if="v.status ==1">Hoạt Động</td>
                    <td class="text-center text-danger" v-else>Bảo Trì</td>
                    <td class="text-center">
                        <button v-on:click="edit = v" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#btn-cap-nhat">
                            Update
                        </button>
                        <button v-on:click="xoa(v.id)" class="btn btn-danger">Xóa</button>
                    </td>
                </tr>
                    {{-- start update --}}
                    <div style="background-color: #ffffff15;color: #7d8da1;" class="modal fade" id="btn-cap-nhat"
                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content ">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Thông Tin Sản Phẩm</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-darkmod">
                                    <label class="form-label">Danh Mục</label>
                                    <select style="background-color: #ffffff15;color: #7d8da1;" v-model="edit.id_danh_muc"
                                        class="form-control">
                                        <template v-for="(v,k) in listDanhMuc">
                                            <option style="background-color: #ffffff15;color: #7d8da1;"
                                                v-bind:value="v.id">@{{ v.ten_danh_muc }}</option>
                                        </template>
                                    </select>
                                    <label class="form-label">Tên Sản Phẩm</label>
                                    <input class="form-control" type="text" v-model="edit.ten_san_pham"
                                        placeholder="Tên Sản Phẩm">
                                    <label>Hình Ảnh</label>
                                    <div class="input-group">
                                        <input id="hinh_anh" class="form-control" type="text"
                                            v-model="edit.hinh_anh" placeholder="Tải Lên Hình Ảnh">
                                        <span class="input-group-prepend">
                                            <a id="lfm_edit" data-input="hinh_anh" data-preview="holder"
                                                class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Chọn Ảnh
                                            </a>
                                        </span>
                                    </div>
                                    <label class="form-label">Mô Tả</label>
                                    <textarea style="background-color: #ffffff15;color: #7d8da1;" placeholder="Mô Tả" class="form-control"
                                        v-model="edit.mo_ta" id="" cols="10" rows="3"></textarea>
                                    <label class="form-label">Link Tải</label>
                                    <input class="form-control" placeholder="Link Tải" type="text"
                                        v-model="edit.link1">
                                    <label class="form-label">Link Video</label>
                                    <input class="form-control" placeholder="Dự Phòng" type="text"
                                        v-model="edit.link2">
                                    <label class="form-label">Tình Trạng</label>
                                    <select style="background-color: #ffffff15;color: #7d8da1;" v-model="edit.status"
                                        class="form-control">
                                        <option style="background-color: #ffffff15;color: #7d8da1;" class="active"
                                            value="1">Hoạt Động</option>
                                        <option style="background-color: #ffffff15;color: #7d8da1;" value="0">Bảo Trì
                                        </option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal" v-on:click="xoa(edit.id)">Xóa Bỏ</button>
                                    <button type="submit" data-bs-dismiss="modal" v-on:click="updateInfo()"
                                        class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                        {{-- end update --}}
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
                listSanPham: [],
                edit: {},
                keyid : {},
                ten_san_pham : null,
                mo_ta : null,
                link1 : null,
                link2 : null,
                view : window.innerWidth,
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
                        .post('/admin/san-pham/add', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.mo_ta = null;
                                this.ten_san_pham = null;
                                this.link1 = null;
                                this.link2 = null;
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
                        .post('/admin/danh-muc/data', 1)
                        .then((res) => {
                            if (res.data.status) {
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
                },
                updateInfo() {
                    axios
                        .post('/admin/san-pham/edit', this.edit)
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
                xoa(id) {
                    if (confirm("Bạn Có Chắc Chắn Muốn Xóa Mục Này Không?")) {
                        axios
                            .post('/admin/san-pham/delete/' + id, id)
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
