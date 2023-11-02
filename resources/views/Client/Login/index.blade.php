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
        <form v-if="check==0" class="login-form" id="formdata" v-on:submit.prevent="login()">
            <input type="username" v-model="username" placeholder="Nhập UserName/Email Của Bạn">
            <input type="password" v-model="password" placeholder="Nhập Mật Khẩu Của Bạn">
            {{-- <button type="submit">Đăng Nhập</button> --}}
            <button type="submit" :disabled="loading">
                <template v-if="loading">
                    Đang xử lý...
                </template>
                <template v-else>
                    Đăng Nhập
                </template>
            </button>
            <span>Chưa Có Tài Khoản ? <a v-on:click="check=1;status='Đăng Ký'" href="#">Đăng Ký Ngay</a></span>
        </form>
        <form v-if="check==1" class="login-form" id="formdata" v-on:submit.prevent="sign()">
            <input type="email" v-model="email" placeholder="Nhập Email Của Bạn">
            <input type="username" v-model="username" placeholder="Nhập Username Của Bạn">
            <input type="password" v-model="password" placeholder="Nhập Mật Khẩu Của Bạn">
            {{-- <button type="submit">Đăng Ký</button> --}}
            <button type="submit" :disabled="loading">
                <template v-if="loading">
                    Đang xử lý...
                </template>
                <template v-else>
                    Đăng Ký
                </template>
            </button>
            <span>Bạn Đã Có Tài Khoản ? <a v-on:click="check=0;status='Đăng Nhập'" href="#">Đăng Nhập Ngay</a></span>
        </form>
        <br>
        <span><a href="/recover">Quên Mật Khẩu?</a></span>
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
                email: null,
                check: 0,
                status: 'Đăng Nhập',
                loading: false,
            },
            created() {

            },
            methods: {
                login() {
                    this.loading = true;

                    $data = {
                            'username': this.username,
                            'password': this.password,
                            'email': this.username,
                        },

                        axios
                        .post('/login-khach-check', $data)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                window.location.href = "/";
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
                sign() {
                    this.loading = true;
                    $data = {
                            'username': this.username,
                            'password': this.password,
                            'email': this.email,
                        },
                        axios
                        .post('/sign-khach-check', $data)
                        .then((res) => {
                            if (res.data.status) {
                                window.location.href = "/";
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
                    }, 2000);
                }
            },
        });
    </script>
</body>

</html>
