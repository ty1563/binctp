@extends('Admin.master')
@section('noi_dung')
    <div class="row" id="app">
        <form id="formdata" v-on:submit.prevent="add()">
            <div>
                <div class="text-center">
                    <h5>Cấu Hình Thông Tin</h5>
                </div>
                <div>
                    <label class="form-label">Họ Và Tên</label>
                    <input class="form-control" type="text" name="full_name">
                    <label class="form-label">Tiêu Đề</label>
                    <input class="form-control" type="text" id="title">
                    <label class="form-label">Nội Dung</label>
                    <input class="form-control" type="text" id="noi_dung">
                    <label class="form-label">Link Fb</label>
                    <input class="form-control" type="text" name="facebook">
                    <label class="form-label">Link Zalo</label>
                    <input class="form-control" type="text" name="zalo">
                    <label class="form-label">Link Telegram</label>
                    <input class="form-control" type="text" name="telegram">
                    <label class="form-label">Link Messenger</label>
                    <input class="form-control" type="text" name="messenger">
                    <label class="form-label">Số Điện Thoại</label>
                    <input class="form-control" type="text" name="sdt">
                    <label class="form-label text-danger">
                        <h2>Cấu Hình Mô Tả</h2>
                    </label>
                    <br>
                    <label class="form-label">Chọn Số Lượng Dòng Muốn Thêm</label>
                    <br>
                    <select class="form-control" id="soLuong" name="soLuong" @change="addInput()">
                        <option value="0">0</option>
                        <option value="2">1</option>
                        <option value="3">2</option>
                        <option value="4">3</option>
                        <option value="5">4</option>
                        <option value="6">5</option>
                    </select>
                    <div id="inputs">
                    </div>
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-success">Thêm Mới</button>
                    </div>
                </div>
        </form>
        <div class="mt-3">
            <table class="table">
                <div>
                    <tr v-if="view>767">
                        <td class="text-center bold-text">#</td>
                        <td class="text-center bold-text">Họ Tên</td>
                        <td class="text-center bold-text">Facebook</td>
                        <td class="text-center bold-text">Zalo</td>
                        <td class="text-center bold-text">Telegram</td>
                        <td class="text-center bold-text">Điện Thoại</td>
                        <td class="text-center bold-text">Action</td>
                    </tr>
                    <tr v-else>
                        <td class="text-center bold-text">#</td>
                        <td class="text-center bold-text">Họ Tên</td>
                        <td class="text-center bold-text">Tiêu Đề</td>
                        <td class="text-center bold-text">Nội Dung</td>
                    </tr>
                </div>
                <div>
                    <tr v-if="view>767" v-for="(v,k) in list">
                        <td class="text-center bold-text">@{{ k + 1 }}</td>
                        <td class="text-center">@{{ v.full_name }}</td>
                        <td class="text-center">@{{ v.facebook }}</td>
                        <td class="text-center">@{{ v.zalo }}</td>
                        <td class="text-center">@{{ v.telegram }}</td>
                        <td class="text-center">@{{ v.sdt }}</td>
                        <td class="text-center">
                            <button @click="edit = v;capNhat()" type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#infoo">
                                Cập Nhật
                            </button>
                        </td>
                    </tr>
                    <tr v-else v-for="(v,k) in list" @click="edit = v;capNhat()" data-bs-toggle="modal"
                        data-bs-target="#infoo">
                        <td class="text-center bold-text">@{{ k + 1 }}</td>
                        <td class="text-center">@{{ v.full_name }}</td>
                        <td class="text-center">@{{ v.title }}</td>
                        <td class="text-center">@{{ v.noi_dung }}</td>
                    </tr>
                </div>
            </table>
            <div class="modal fade" id="infoo" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Thông Tin</h5>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Họ Và Tên</label>
                            <input class="form-control" type="text" id="full_name1" v-model="edit.full_name">
                            <label class="form-label">Tiêu Đề</label>
                            <input class="form-control" type="text" name="title" v-model="edit.title">
                            <label class="form-label">Nội Dung</label>
                            <input class="form-control" type="text" name="noi_dung" v-model="edit.noi_dung">
                            <label class="form-label">Link Fb</label>
                            <input class="form-control" type="text" id="facebook1" v-model="edit.facebook">
                            <label class="form-label">Link Zalo</label>
                            <input class="form-control" type="text" id="zalo1" v-model="edit.zalo">
                            <label class="form-label">Link Telegram</label>
                            <input class="form-control" type="text" id="telegram1" v-model="edit.telegram">
                            <label class="form-label">Link Messenger</label>
                            <input class="form-control" type="text" id="messenger1" v-model="edit.messenger">
                            <label class="form-label">Số Điện Thoại</label>
                            <input class="form-control" type="text" id="sdt1" v-model="edit.sdt">
                            <label class="form-label text-danger">
                                <h2>Cấu Hình Mô Tả</h2>
                            </label>
                            <br>
                            <label class="form-label">Chọn Số Lượng Dòng Muốn Thêm</label>
                            <br>
                            <select class="form-control" v-model="edit.count" id="soLuong1" name="soLuong"
                                @change="editInput()">
                                <option value="0">0</option>
                                <option value="2">1</option>
                                <option value="3">2</option>
                                <option value="4">3</option>
                                <option value="5">4</option>
                                <option value="6">5</option>
                            </select>
                            <div id="edit">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" v-on:click="xoa(edit.id)" class="btn btn-danger"
                                data-bs-dismiss="modal">Xóa</button>
                            <button type="submit" v-on:click="updateThongTin()" class="btn btn-primary"
                                data-bs-dismiss="modal">Lưu</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                edit: {},
                list: [],
                content: false,
                view: window.innerWidth,
                // type: 1,
            },
            created() {
                this.load();
            },
            methods: {
                updateThongTin() {
                    var dataUpdate = {
                        'full_name': $("#full_name1").val() ? $("#full_name1").val() : null,
                        'facebook1': $("#facebook1").val() ? $("#facebook1").val() : null,
                        'zalo': $("#zalo1").val() ? $("#zalo1").val() : null,
                        'telegram': $("#telegram1").val() ? $("#telegram1").val() : null,
                        'messenger': $("#messenger1").val() ? $("#messenger1").val() : null,
                        'title': $("#title").val() ? $("#title").val() : null,
                        'noi_dung': $("#noi_dung").val() ? $("#noi_dung").val() : null,
                        'sdt': $("#sdt1").val() ? $("#sdt1").val() : null,
                        'tieuDe1': $("#tieuDe1").val() ? $("#tieuDe1").val() : null,
                        'tieuDe2': $("#tieuDe2").val() ? $("#tieuDe2").val() : null,
                        'tieuDe3': $("#tieuDe3").val() ? $("#tieuDe3").val() : null,
                        'tieuDe4': $("#tieuDe4").val() ? $("#tieuDe4").val() : null,
                        'tieuDe5': $("#tieuDe5").val() ? $("#tieuDe5").val() : null,
                        'linkDong1': $("#linkDong1").val() ? $("#linkDong1").val() : null,
                        'linkDong2': $("#linkDong2").val() ? $("#linkDong2").val() : null,
                        'linkDong3': $("#linkDong3").val() ? $("#linkDong3").val() : null,
                        'linkDong4': $("#linkDong4").val() ? $("#linkDong4").val() : null,
                        'linkDong5': $("#linkDong5").val() ? $("#linkDong5").val() : null,
                    };
                    axios
                        .post('/admin/thong-tin/capNhat', dataUpdate)
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
                editInput() {
                    var soLuong1 = $('#soLuong1').val();
                    var inputs = $('#edit').empty();
                    for (i = 1; i < soLuong1; i++) {
                        inputs.append('<div class="input-group"');
                        inputs.append('<span class="input-group-text">Dòng ' + i + '</span>');
                        inputs.append('<input type="text" id="tieuDe' + i +
                            '" aria-label="First name" placeholder="Tiêu Đề Dòng ' + i +
                            '" class="form-control mt-1">');
                        inputs.append('<input type="text" id="linkDong' + i +
                            '" aria-label="Last name" placeholder="Link Đi Kèm Dòng ' + i +
                            ' (*Nếu Có)" class="form-control mt-1">');
                        inputs.append('</div>');
                    }
                },
                capNhat() {
                    this.edit.count = this.edit.mo_ta.split(',').length + 1;
                    var array = this.edit.mo_ta.split(',');
                    var edit = $('#edit').empty();
                    for (i = 1; i < this.edit.count; i++) {
                        edit.append('<div class="input-group"');
                        edit.append('<span class="input-group-text">Dòng ' + i + '</span>');
                        edit.append('<input type="text" id="tieuDe' + i +
                            '" value="' + array[i - 1].split('|')[0] +
                            '" aria-label="First name" placeholder="Tiêu Đề Dòng ' + i +
                            '" class="form-control mt-1">');
                        edit.append('<input type="text" id="linkDong' + i +
                            '" value="' + array[i - 1].split('|')[1] +
                            '" aria-label="Last name" placeholder="Link Đi Kèm Dòng ' + i +
                            ' (*Nếu Có)" class="form-control mt-1">');
                        edit.append('</div>');
                    }
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
                    paramObj.title = $("#title").val();
                    paramObj.noi_dung = $("#noi_dung").val();
                    axios
                        .post('/admin/thong-tin/add', paramObj)
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
                        .post('/admin/thong-tin/data', 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.list = res.data.data;
                            } else {
                                setTimeout(() => {
                                    this.load();
                                }, 10000);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                xoa(id) {
                    if (confirm("Bạn Có Chắc Chắn Muốn Xóa Mục Này Không ?")) {
                        axios
                            .post('/admin/thong-tin/delete/' + id, id)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message);
                                    this.load();
                                } else {
                                    toastr.error('Xóa Thất Bại');
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors, function(k, v) {
                                    toastr.error(v[0]);
                                });
                            });
                    }
                },
                addInput() {
                    var soLuong = $('#soLuong').val();
                    var inputs = $('#inputs').empty();
                    for (i = 1; i < soLuong; i++) {
                        inputs.append('<div class="input-group"');
                        inputs.append('<span class="input-group-text">Dòng ' + i + '</span>');
                        inputs.append('<input type="text" name="tieuDe' + i +
                            '" aria-label="First name" placeholder="Tiêu Đề Dòng ' + i +
                            '" class="form-control mt-1">');
                        inputs.append('<input type="text" name="linkDong' + i +
                            '" aria-label="Last name" placeholder="Link Đi Kèm Dòng ' + i +
                            ' (*Nếu Có)" class="form-control mt-1">');
                        inputs.append('</div>');
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
