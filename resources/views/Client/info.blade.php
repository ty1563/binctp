@extends('Client.home_page')
@section('css')
    <link href="/plugins/notifications/css/lobibox.min.css" rel="stylesheet" />
    <link href="/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <script src="/js/pace.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.2/axios.min.js"
        integrity="sha512-NCiXRSV460cHD9ClGDrTbTaw0muWUBf/zB/yLzJavRsPNUl9ODkUVmUHsZtKu17XknhsGlmyVoJxLg/ZQQEeGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toast-css/1.1.0/grid.min.css"
        integrity="sha512-YOGZZn5CgXgAQSCsxTRmV67MmYIxppGYDz3hJWDZW4A/sSOweWFcynv324Y2lJvY5H5PL2xQJu4/e3YoRsnPeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap  -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/bootstrap.css">
@endsection
@section('noi_dung')
    @php
        $soDu = number_format(Auth::guard('khach')->user()->coin, 0, ',', '.') . '₫';
    @endphp
    <section class="section bd-container" id="app">
        <h4 class="font-weight-bold py-3 mb-4">
            Thông Tin Tài Khoản
        </h4>
        <div class="card">
            <div class="col-md-12">
                <div v-if='check==0' class="card-body">
                    {{-- Username --}}

                    <label class="form-label mt-3">Username</label>
                    <div class="input-group" v-if="changeUser == 0">
                        <input type="text" class="form-control" :value="user" aria-describedby="button-addon2"
                            readonly disabled>
                        <button v-on:click="changeUser = 1" class="btn btn-outline-primary" type="button"
                            id="button-addon2">Thay Đổi Username</button>
                    </div>
                    <form v-if="changeUser==1" id="formUser" v-on:submit.prevent="changeUsername()">
                        <label class="form-label">Kiểm Tra Username</label>
                        <div class="input-group">
                            <input type="hidden" name="old" class="form-control" :value="user">
                            <input name="username" type="text" class="form-control" :value="user">
                            <button class="btn btn-outline-danger" type="submit">Lưu Lại Thay Đổi</button>
                        </div>
                    </form>

                    {{-- Coin  --}}
                    <label class="form-label">Số Dư</label>
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $soDu }}"
                            aria-describedby="button-addon2" readonly disabled>
                        <a href="/naptien" class="btn btn-outline-primary" type="button" id="button-addon2">Nạp Tiền</a>
                    </div>


                    {{-- Email  --}}
                    <form v-if="emailstatus==0" v-on:submit.prevent="sendMail()" class="form-group" id="formemail">
                        <label class="form-label">E-mail</label>
                        <input name="email" type="text" class="form-control mb-1" :value="email" readonly
                            disabled>
                        @if (Auth::guard('khach')->user()->active == 0)
                            <div class="alert alert-warning mt-3">
                                Bạn Chưa Xác Minh Email , Vui Lòng Xác Minh Email Của Mình<br>
                                <button class="btn btn-primary" type="submit">Gửi Mã Xác Minh</button>
                            </div>
                        @else
                            <div class="alert alert-success mt-3">
                                Email Đã Được Xác Minh
                                <br>
                                <button @click="emailstatus = 1;changeMail()" class="btn btn-outline-primary"
                                    type="submit">Thay Đổi Email Khác</button>
                            </div>
                        @endif
                    </form>
                    <form v-if="emailstatus == 1" v-on:submit.prevent="checkMail()" class="form-group">
                        <label class="form-label">Nhập Mã Xác Nhận</label>
                        <input type="text" class="alert alert-info mt-3" v-model="hash">
                        <button @click="confirmChangeMail()" class="btn btn-outline-primary" type="submit">Kiểm
                            Tra</button>
                    </form>
                    <form v-if="emailstatus == 2" v-on:submit.prevent="checkMail()" class="form-group">
                        <label class="form-label">Nhập Email Mới</label>
                        <input type="text" class="alert alert-success mt-3" v-model="newEmail">
                        <button @click="change()" class="btn btn-outline-primary" type="submit">Xác Nhận</button>
                    </form>
                </div>
                <div v-if='check==1' class="card-body">
                    {{-- Password --}}
                    <form id="formPassword" v-on:submit.prevent="changePassword()">
                        <label class="form-label mt-3"><b>Thay Đổi Mật khẩu</b></label>
                        <input name="password" type="text" class="form-control mt-3" placeholder="Nhập Mật Khẩu Cũ">
                        <input name="newPassword" type="text" class="form-control mt-3" placeholder="Nhập Mật Khẩu Mới">
                        <input name="newPassword1" type="text" class="form-control mt-3" placeholder="Nhập Lại Mật Khẩu">
                        <button class="btn btn-outline-success mt-3 ml-3" type="submit">Lưu Lại Thay Đổi</button>
                        <button v-on:click='check=0' class="btn btn-outline-danger mt-3 ml-1" type="submit">Trở Về</button>
                    </form>
                </div>
                <div class="form-group" style="margin-left: 10px;">
                    <a href="/history" type="button" class="m-1 btn btn-primary">Xem Lịch Sử Mua Hàng</a>
                    <a v-on:click="check=1" href="#" type="button" class="m-1 btn btn-warning">Thay Đổi Mật
                        Khẩu</a>
                    <a href="/logout" type="button" class="m-1 btn btn-danger"> Đăng Xuất <svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                            <path fill-rule="evenodd"
                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                        </svg></a>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="/js/jquery.min.js"></script>
    <script src="/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/plugins/chartjs/js/Chart.min.js"></script>
    <script src="/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
    <!--notification js -->
    <script src="/plugins/notifications/js/lobibox.min.js"></script>
    <script src="/plugins/notifications/js/notifications.min.js"></script>
    <script src="/js/index3.js"></script>
    <!--app JS-->
    <script src="/js/app.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        new Vue({
            el: '#app',
            data: {
                changeUser: 0,
                emailstatus: 0,
                user: '{{ Auth::guard('khach')->user()->username }}',
                email: '{{ Auth::guard('khach')->user()->email }}',
                hash: null,
                newEmail: null,
                check: 0,
            },
            created() {

            },
            methods: {
                changePassword(){
                    var paramObj = {};
                    $.each($('#formPassword').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    paramObj.username = this.user;
                    axios
                        .post('/recoverPassowrd', paramObj)
                        .then((res) => {
                         if(res.data.status){
                            this.check=0;
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
                change() {
                    var data = {
                        'old': this.email,
                        'new': this.newEmail,
                    };
                    axios
                        .post('/changeEmail', data)
                        .then((res) => {
                            if (res.data.status) {
                                this.email = res.data.new;
                                this.emailstatus = 0;
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
                confirmChangeMail() {
                    var data = {
                        'email': this.email,
                        'hash_reset': this.hash,
                    };
                    axios
                        .post('/confirmChangeMail', data)
                        .then((res) => {
                            if (res.data.status) {
                                this.emailstatus = 2;
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
                changeUsername() {
                    var paramObj = {};
                    $.each($('#formUser').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });

                    axios
                        .post('/changeUsername', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.changeUser = 0;
                                this.user = res.data.new;
                            } else {
                                this.changeUser = 0;
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                sendMail() {
                    var paramObj = {};
                    $.each($('#formemail').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    axios
                        .post('/sendMailConfirmEmail', paramObj)
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
                changeMail() {
                    var data = {
                        'email': this.email,
                    };
                    axios
                        .post('/sendMailChangeEmail', data)
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
            },
        });
    </script>
@endsection
