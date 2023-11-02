
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Login_Admin/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.2/axios.min.js" integrity="sha512-NCiXRSV460cHD9ClGDrTbTaw0muWUBf/zB/yLzJavRsPNUl9ODkUVmUHsZtKu17XknhsGlmyVoJxLg/ZQQEeGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toast-css/1.1.0/grid.min.css" integrity="sha512-YOGZZn5CgXgAQSCsxTRmV67MmYIxppGYDz3hJWDZW4A/sSOweWFcynv324Y2lJvY5H5PL2xQJu4/e3YoRsnPeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .form-control,table,tr,th,td {
          border-radius: 10px;
        }
        .card{
            border: none;
        }
        body, p, a, h1, h2, h3, h4, h5, h6, span, div{
            text-decoration: none !important;
        }
        .bold-text {
        font-weight: bold;
        }
        .text-darkmod{
            background-color: #ffffff15;
            color: #7d8da1;
        }
        input[type="text"], input[type="password"], input[type="email"] {
        background-color: #ffffff15;
        color: #7d8da1;
        padding: 5px;
        }
      </style>
    <title>Admin | Đăng Nhập</title>
</head>
<body>
    <div class="login-card" id="app">
        <h2>Login</h2>
        <h3 style="color:red;">@{{alert}}</h3>
        <form v-on:submit.prevent="dangNhap()" id="formdata" class="login-form mt-3">
            <input name="username" type="text" placeholder="Email / Username">
            <input name="password" type="password" placeholder="Password">
            {{-- <a href="#">Forget your password?</a> --}}
            <button type="submit">LOGIN</button>
        </form>
    </div>
</body>
<script>
new Vue({
    el      :   '#app',
    data    :   {
        alert : null,
    },
    created()   {

    },
    methods :   {
        dangNhap(){
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
                .post('/admin/login-admin-check', paramObj)
                .then((res) => {
                 if(res.data.status){
                    toastr.success('Đăng Nhập Thành Công');
                    window.location.href = '/admin/chuyen-muc';
                } else {
                    this.alert = 'Tên Tài Khoản Hoặc Mật Khẩu Không Chính Xác';
                    toastr.error(this.alert);
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
</html>

