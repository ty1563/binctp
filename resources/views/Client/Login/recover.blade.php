<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/Login_Client/style.css">
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
</head>

<body>

    <div class="login" id="app">
        {{-- <img src="/Login_client/bg.jpg" alt=""> --}}
        <h3><span>@{{ status }}</span></h3>
        <h2>BinTP.Com</h2>
        <form v-if="check==0" class="login-form" id="formdata" v-on:submit.prevent="sendMail()">
            <input type="username" v-model="email" placeholder="Nhập Email Của Bạn">
            <button type="submit" :disabled="loading">
                <template v-if="loading">
                    Đang xử lý...
                </template>
                <template v-else>
                    Gửi Mã Xác Nhận
                </template>
            </button>
        </form>
        <form v-if="check==1" class="login-form text-center" id="formdata" v-on:submit.prevent="checkMa()">
            <input type="username" v-model="ma" placeholder="Nhập Mã Xác Nhận">
            <button type="submit" :disabled="loading">
                <template v-if="loading">
                    Đang xử lý...
                </template>
                <template v-else>
                    Kiểm Tra
                </template>
            </button>
        </form>
        <form v-if="check==2" class="login-form text-center" id="formdata" v-on:submit.prevent="recover()">
            <input type="username" v-model="password" placeholder="Nhập Mật Khẩu Mới">
            <input type="username" v-model="password2" placeholder="Nhập Lại Mật Khẩu">
            <button type="submit" :disabled="loading">
                <template v-if="loading">
                    Đang xử lý...
                </template>
                <template v-else>
                    Đổi Mật Khẩu
                </template>
            </button>
        </form>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="/js/jquery.min.js"></script>
    <script src="/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
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
                username: null,
                password: null,
                password2: null,
                email: null,
                check: 0,
                status: 'Quên Mật Khẩu',
                loading: false,
            },
            created() {

            },
            methods: {
                recover() {
                    this.loading = true;
                    if (this.password != this.password2)
                        return toastr.error("2 Mật Khẩu Không Giống Nhau");
                    var data = {
                        'email': this.email,
                        'hash_reset': this.ma,
                        'password': this.password,
                    };
                    axios
                        .post('/changePassword', data)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                toastr.success('Đang Chuyển Hướng Trang');
                                setTimeout(() => {
                                    this.loading = false;
                                }, 2000);
                                window.location.href = '/login';
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                    setTimeout(() => {
                        this.loading = false;
                    }, 2000);
                },
                sendMail() {
                    this.loading = true;
                    var data = {
                        'email': this.email,
                    };
                    axios
                        .post('/sendMailRecover', data)
                        .then((res) => {
                            if (res.data.status) {
                                this.check = 1;
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
                    setTimeout(() => {
                        this.loading = false;
                    }, 1000);
                },
                checkMa() {
                    this.loading = true;
                    var data = {
                        'email': this.email,
                        'hash_reset': this.ma,
                    };
                    axios
                        .post('/checkMailRecover', data)
                        .then((res) => {
                            if (res.data.status) {
                                this.check = 2;
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
                    setTimeout(() => {
                        this.loading = false;
                    }, 1000);
                },
            },
        });
    </script>
</body>

</html>
