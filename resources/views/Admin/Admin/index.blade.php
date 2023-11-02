@extends('Admin.master')

@section('noi_dung')
    <div class="row" id="app">
        <div>
            <div class="text-center">
                <h5>Thêm Mới Admin</h5>
            </div>
            <div>
                <label class="form-label">UserName</label>
                <input class="form-control" type="text" name="username" v-model="username">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email" v-model="email">
                <label class="form-label">Password</label>
                <input class="form-control" type="text" name="password" v-model="password">
                <label class="form-label">Number</label>
                <input class="form-control" type="text" name="sdt" v-model="sdt">
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#permissionModal">
                    Select Quyền
                </button>
                <template v-for="(v,k) in list_select">
                    <tr>
                        @{{ v }}
                    </tr>
                </template>
                <!-- Modal -->
                <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="permissionModalLabel">Xét quyền</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label>
                                    <input type="checkbox" v-model="select.quyen_chuyen_muc">
                                    Chuyên Mục
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_danh_muc">
                                    Danh Mục
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_san_pham">
                                    Danh Sách Sản Phẩm
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_key">
                                    Danh Sách Đang Bán
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_lich_su">
                                    Danh Sách Lịch Sử
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_khach_hang">
                                    Danh Sách Khách Hàng
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_info">
                                    Chỉnh Sửa Thông Tin
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_question">
                                    Chỉnh Sửa Hỏi & Trả Lời
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_setting">
                                    Chỉnh Sửa Trang Web
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_admin">
                                    Quyền Thêm Admin
                                </label>
                                <label>
                                    <input type="checkbox" v-model="select.quyen_tintuc">
                                    Quyền Tin Tức
                                </label>
                             </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" data-bs-dismiss="modal" v-on:click="select_quyen()"
                                    class="btn btn-primary">Lưu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success" v-on:click="add()">Thêm Mới</button>
            </div>
        </div>
        <div class="mt-3">
            <table class="table">
                <tr>
                    <td class="text-center bold-text">#</td>
                    <td class="text-center bold-text">Name</td>
                    <td class="text-center bold-text">Email</td>
                    <td class="text-center bold-text">SDT</td>
                    <td class="text-center bold-text">Action</td>
                </tr>
                <tr v-for="(v,k) in list_admin">
                    <td class="text-center bold-text">@{{ k + 1 }}</td>
                    <td class="text-center">@{{ v.username }}</td>
                    <td class="text-center">@{{ v.email }}</td>
                    <td class="text-center">@{{ v.sdt }}</td>
                    <td class="text-center">
                        <button v-on:click="edit = v , sendMail()" type="button" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#infoo">
                            Thay Đổi Mật Khẩu
                        </button>
                        <button v-on:click="xoa(v.username)" class="btn btn-danger">Xóa Bỏ</button>
                    </td>
                </tr>
                <div class="modal fade" id="infoo" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h5 style="color: rgb(0, 0, 0);">Nhập Mã Xác Nhận Đã Gửi Về Gmail <br><b>@{{ edit.email }}</b></h5>
                                <div>
                                    <input v-model="ma" style="width: 65%;border:2px solid red;" class="d-inline" type="text"
                                    placeholder="Gồm 6 Chữ Số Ví Dụ  : 524324">
                                    <button v-on:click="xacNhanReset()" class="d-inline btn btn-info">Xác Nhận</button>
                                    <input v-if="check" type="text" v-model="password_change" class="form-control mt-4" placeholder="Nhập Mật Khẩu Mới">
                                </div>
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
                check : false,
                username: null,
                email: null,
                password: null,
                sdt: null,
                id_quyen: null,
                ma: null,
                password_change : null,
                select: {
                    quyen_chuyen_muc: false,
                    quyen_danh_muc: false,
                    quyen_san_pham: false,
                    quyen_key: false,
                    quyen_khach_hang: false,
                    quyen_info: false,
                    quyen_setting: false,
                    quyen_question: false,
                    quyen_admin: false,
                },
                list_select: [],
                list_admin: [],
                edit: {},
            },
            created() {
                this.load();
            },
            methods: {
                org(){
                    this.username =  null;
                    this.email =  null;
                    this.password =  null;
                    this.sdt =  null;
                    this.id_quyen =  null;
                    this.select.quyen_chuyen_muc =  false;
                    this.select.quyen_danh_muc =  false;
                    this.select.quyen_san_pham =  false;
                    this.select.quyen_key =  false;
                    this.select.quyen_khach_hang =  false;
                    this.select.quyen_setting =  false;
                    this.select.quyen_admin =  false;
                    this.select.quyen_setting =  false;
                    this.select.quyen_info =  false;
                    this.list_select = [];
                },
                add() {
                    var data = {
                        'username': this.username,
                        'email': this.email,
                        'sdt': this.sdt,
                        'password': this.password,
                        'id_quyen': this.id_quyen,
                    };
                    axios
                        .post('/admin/add', data)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.org();
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
                select_quyen() {
                    this.list_select = Object.keys(this.select).filter(key => this.select[
                    key]); // lấy tên list checkbox
                    this.id_quyen = this.list_select.join(',');
                },
                load() {
                    axios
                        .post('/admin/data', 1)
                        .then((res) => {
                            this.list_admin = res.data.data;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                sendMail() {
                    axios
                        .post('/admin/sendMail', this.edit)
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
                xacNhanReset(){
                    this.edit.ma = this.ma;
                    axios
                        .post('/admin/change', this.edit)
                        .then((res) => {
                         if(res.data.status){
                            toastr.success(res.data.message);
                            this.check = true;
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
                updateInfo(){
                    this.edit.password_change = this.password_change;
                    axios
                        .post('/admin/change_password', this.edit)
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
                xoa(username){
                    if(confirm("Bạn Có Chắc Chắn Xóa Mục Này Không?")){
                        axios
                            .post('/admin/delete/'+username, username)
                            .then((res) => {
                             if(res.data.status){
                                this.load();
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
                }
            },
        });
    </script>
@endsection
