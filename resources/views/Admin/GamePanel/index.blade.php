@extends('Admin.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <form id="formdata" v-on:submit.prevent="add()">
                <div>
                    <div class="text-center">
                        <h5>Tạo Mới Key</h5>
                    </div>
                    <div>
                        <label>Chọn Game</label>
                        <select name="game" class="form-control text-darkmod" required>
                            <option value="PUBG" active>PUBG</option>
                            <option value="LIENQUAN">LIÊN QUÂN</option>
                            <option value="TOCCHIEN">TỐC CHIẾN</option>
                        </select>
                        <label>Thời Gian</label>
                        <select name="thoi_gian" class="form-control text-darkmod" required>
                            <option value="2" active>2 Giờ</option>
                            <option value="24">1 NGÀY</option>
                            <option value="168">7 NGÀY</option>
                            <option value="720">30 NGÀY</option>
                            <option value="1440">60 NGÀY</option>
                        </select>
                        <label>Số Thiết Bị</label>
                        <input type="number" value="1" class="form-control text-darkmod" name="max_devices" required>
                        <label>Số Lượng</label>
                        <input type="number" value="1" class="form-control text-darkmod" name="number" required>
                    </div>
                    <div class="text-end mt-1">
                        <button type="submit" class="btn btn-success">Tạo Mới</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-2"></div>
        <div v-if="keyDaTao!=null" class="col-sm-8 text-center">
            <h5>List Key Vừa Tạo</h5>
            <textarea :value="keyDaTao" cols="40" rows="5" class="text-darkmod"></textarea>
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-12 mt-4">
            <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#cauHinh"><i
                    class="fa fa-bars"></i> Cấu Hình Menu Game</button>
            <div v-if="view>767">
                <button v-if="mulselect == 0" class="btn btn-info" @click="mulselect =1">Chọn Nhiều</button>
                <button v-if="mulselect == 1" class="btn btn-info" @click="mulselect =0">Hủy</button>
                <button v-if="mulselect == 1" class="btn btn-danger" @click="mulselect =0;xoaNhieu()"><i
                        class="fa fa-trash"></i>Xóa Mục Đã Chọn</button>
                <button v-if="mulselect == 0" class="btn btn-danger" @click="mulselect =0;xoaAll()">Xóa Tất Cả</button>
            </div>
            <table class="table">
                <tr>
                    <td v-if="mulselect==1" class="text-center bold-text">Select</td>
                    <td class="text-center bold-text">Người Tạo</td>
                    <td class="text-center bold-text">Key</td>
                    <td class="text-center bold-text">Game</td>
                    <td class="text-center bold-text">Thời Gian</td>
                    <td class="text-center bold-text">Trạng Thái</td>
                    <td v-if="mulselect==0" class="text-center bold-text">Action</td>
                </tr>
                <tr v-if="view>767" v-for="(v,k) in listKey">
                    <td class="text-center" v-if="mulselect ==1">
                        <input type="checkbox" v-model="selectedItems" :value="v.id">
                    </td>
                    <td class="text-center">@{{ v.nguoi_tao }}</td>
                    <td class="text-center" v-on:click="copyMa(v.user_key)"><b
                            class="text-primary">@{{ v.user_key }}</b></td>
                    <td class="text-center">@{{ v.game }}</td>
                    <td class="text-center">@{{ v.thoi_gian + ' Giờ' }}</td>
                    <td class="text-center">@{{ v.status == 0 ? 'Chưa Kích Hoạt' : 'Đã Kích Hoạt' }}</td>
                    <td class="text-center" v-if="mulselect==0">
                        <button v-on:click="edit = v" type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#infoo">
                            Cập Nhật
                        </button>
                        <button v-on:click="xoa(v.id)" class="btn btn-danger">Xóa Bỏ</button>
                    </td>
                </tr>
                <tr v-if="view<767" v-for="(v,k) in listKey" v-on:click="edit = v" data-bs-toggle="modal"
                    data-bs-target="#infoo">
                    <td class="text-center" v-if="mulselect ==1">
                        <input type="checkbox" v-model="selectedItems" :value="v.id">
                    </td>
                    <td class="text-center">@{{ v.nguoi_tao }}</td>
                    <td class="text-center" v-on:click="copyMa(v.user_key)"><b
                            class="text-primary">@{{ v.user_key }}</b></td>
                    <td class="text-center">@{{ v.game }}</td>
                    <td class="text-center">@{{ v.thoi_gian + ' Giờ' }}</td>
                    <td class="text-center">@{{ v.status == 0 ? 'Chưa Kích Hoạt' : 'Đã Kích Hoạt' }}</td>
                </tr>
                <div class="modal fade" id="infoo" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Key</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>Key Code</label>
                                <input type="text"class="form-control text-darkmod" v-model="edit.user_key" required>
                                <label>Chọn Game</label>
                                <select v-model="edit.game" class="form-control text-darkmod" required>
                                    <option value="PUBG" active>PUBG</option>
                                    <option value="LIENQUAN">LIÊN QUÂN</option>
                                    <option value="TOCCHIEN">TỐC CHIẾN</option>
                                </select>
                                <label>Thời Gian</label>
                                <select v-model="edit.thoi_gian" class="form-control text-darkmod" required>
                                    <option value="2" active>2 Giờ</option>
                                    <option value="24">1 NGÀY</option>
                                    <option value="168">7 NGÀY</option>
                                    <option value="720">30 NGÀY</option>
                                    <option value="1440">60 NGÀY</option>
                                </select>
                                <label>Số Thiết Bị</label>
                                <input type="number" class="form-control text-darkmod" v-model="edit.max_devices"
                                    required>
                                <label class="form-label">Danh Sách Thiết Bị</label>
                                <textarea class="form-control" v-model="edit.devices" id="" cols="30" rows="10"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button data-bs-dismiss="modal" v-on:click="xoa(edit.id)" class="btn btn-danger">Xóa
                                    Bỏ</button>
                                <button type="submit" data-bs-dismiss="modal" v-on:click="updateInfo()"
                                    class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="cauHinh" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cấu Hình Menu Game</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="form-label">Tên Menu</label>
                                <input type="text" class="form-control" v-model="ten_menu">
                                <label class="form-label">Thông Báo</label>
                                <input type="text" class="form-control" v-model="thong_bao">
                                <label class="form-label">Tình Trạng</label>
                                <select class="form-control" v-model="tinh_trang">
                                    <option value="1">Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                                <label class="form-label">ESP</label>
                                <select class="form-control" v-model="esp_status">
                                    <option value="1">Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                                <label class="form-label">AimBot</label>
                                <select class="form-control" v-model="aimbot_status">
                                    <option value="1">Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                                <label class="form-label">Bullet Tracking</label>
                                <select class="form-control" v-model="bullet_status">
                                    <option value="1">Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                                <label class="form-label">Memory Hack</label>
                                <select class="form-control" v-model="memory_status">
                                    <option value="1">Mở</option>
                                    <option value="0">Đóng</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" data-bs-dismiss="modal" v-on:click="updateSetting()"
                                    class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ 'disabled': !pagination.prev_page_url }">
                        <a class="page-link" href="#" v-on:click.prevent="load(pagination.current_page - 1)">Trang
                            Trước</a>
                    </li>
                    <li class="page-item" :class="{ 'disabled': !pagination.next_page_url }">
                        <a class="page-link" href="#" v-on:click.prevent="load(pagination.current_page + 1)">Trang
                            Kế</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                mulselect: 0,
                selectedItems: [],
                listKey: [],
                keyDaTao: null,
                pagination: null,
                edit: {},
                view: window.innerWidth,
                ten_menu: null,
                tinh_trang: null,
                thong_bao: null,
                esp_status: null,
                aimbot_status: null,
                bullet_status: null,
                memory_status: null,
            },
            created() {
                this.load(1);
                this.loadSetting();
            },
            methods: {
                updateSetting() {
                    var data = {
                        "ten_menu" : this.ten_menu,
                        "tinh_trang" : this.tinh_trang,
                        "thong_bao" : this.thong_bao,
                        "esp_status" : this.esp_status,
                        "aimbot_status" : this.aimbot_status,
                        "bullet_status" : this.bullet_status,
                        "memory_status" : this.memory_status,
                    };
                    axios
                        .post('/admin/panel-game/updateSetting', data)
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
                loadSetting() {
                    axios
                        .post('/admin/panel-game/load-setting', 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.ten_menu = res.data.data.ten_menu;
                                this.tinh_trang = res.data.data.tinh_trang;
                                this.thong_bao = res.data.data.thong_bao;
                                this.esp_status = res.data.data.esp_status;
                                this.aimbot_status = res.data.data.aimbot_status;
                                this.bullet_status = res.data.data.bullet_status;
                                this.memory_status = res.data.data.memory_status;
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
                        .post('/admin/panel-game/update', this.edit)
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
                xoaAll() {
                    if (confirm(
                            "Bạn Có Chắc Chắn Muốn Xóa Tất Cả Các Key Không? Hành Động Sẽ Không Được Khôi Phục Lại"
                        )) {
                        axios
                            .post('/admin/panel-game/deleteAll', 1)
                            .then((res) => {
                                if (res.data.status) {
                                    this.load(1);
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
                    }
                },
                xoaNhieu() {
                    axios
                        .post('/admin/panel-game/MultiDelete', this.selectedItems)
                        .then((res) => {
                            if (res.data.status) {
                                this.load(1);
                                this.selectedItems = [];
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
                    axios
                        .post('/admin/panel-game/delete/' + id, id)
                        .then((res) => {
                            if (res.data.status) {
                                this.load(1);
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
                copyMa(key) {
                    navigator.clipboard.writeText(key)
                        .then(() => {
                            toastr.success("Copy Key Thành Công");
                        })
                        .catch((error) => {
                            toastr.error("Có Lỗi Sãy Ra", error);
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
                        .post('/admin/panel-game/add', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                this.load(1);
                                this.keyDaTao = res.data.keys.join('\n');
                                toastr.success(res.data.message);
                                if (confirm("Bạn Có Muốn Tải Những Key Đã Tạo Về Máy Không?")) {
                                    var keysString = res.data.keys.join('\n');
                                    var keysBlob = new Blob([keysString], {
                                        type: 'text/plain'
                                    });
                                    var keysUrl = URL.createObjectURL(keysBlob);

                                    var downloadLink = document.createElement('a');
                                    downloadLink.href = keysUrl;
                                    downloadLink.download = 'keys.txt';
                                    downloadLink.click();
                                }
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
                load(page) {
                    axios
                        .post('/admin/panel-game/data?page=' + page, 1)
                        .then((res) => {
                            if (res.data.status) {
                                this.listKey = res.data.data.data;
                                this.pagination = res.data.data;
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
@endsection
