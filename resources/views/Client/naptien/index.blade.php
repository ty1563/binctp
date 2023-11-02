@extends('Client.home_page')
@section('css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <style>
        @media (max-width: 767px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
@endsection
@section('noi_dung')
    <div class="accessory section bd-container" id="app">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <button v-if="get===0" @click="getChuyenKhoan()"
                        class="btn btn-outline-primary">@{{ status }}</button>
                    <div v-if="get==1">
                        <div class="card-header">
                            <tr class="text-center">
                                <th class="text-center">
                                    <button @click="select=0"
                                        :class="{ 'btn': true, 'btn-outline-danger': select !== 0, 'btn-danger': select === 0 }">
                                        Ngân Hàng
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button @click="select=1"
                                        :class="{ 'btn': true, 'btn-outline-danger': select !== 1, 'btn-danger': select === 1 }">
                                        MOMO
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button @click="select=2"
                                        :class="{ 'btn': true, 'btn-outline-danger': select !== 2, 'btn-danger': select === 2 }">
                                        Thẻ Cào
                                    </button>
                                </th>
                            </tr>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                {{-- BANK  --}}

                                <table v-if="select===0" class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="text-center">Ngân Hàng</th>
                                            <th class="text-center">Số Tài Khoản</th>
                                            <th class="text-center">Chủ Tài Khoản</th>
                                            <th class="text-center">Mã Nạp Tiền</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center" style="width: 30%;"><img
                                                    src="/assets_client/img/saccombank.png"></td>
                                            <td class="text-center">060154470452</td>
                                            <td class="text-center">CHUNG TUAN PHAT</td>
                                            <td class="text-center"><a @click="copyMa()" href="#"
                                                    class="text-primary"><b>@{{ ma }}</b></a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                {{-- MOMO  --}}
                                <table v-if="select===1" class="table table-bordered">
                                    <tr>
                                        <th class="text-center">MOMO</th>
                                        <th class="text-center">Số Điện Thoại</th>
                                        <th class="text-center">Mã Nạp Tiền</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="width: 30%;"><img style="max-height: 50px;"
                                                src="/assets_client/img/momo.png"></td>
                                        <td class="text-center">0938428002</td>
                                        <td class="text-center"><a @click="copyMa()" href="#"
                                                class="text-primary"><b>@{{ ma }}</b></a></td>
                                    </tr>
                                </table>

                                {{-- THE CAO  --}}
                                <template v-if="select===2">
                                    <table class="table table-bordered">
                                            <label class="form-label">Chọn Loại Thẻ</label>
                                            <select name="type" id="type" class="form-control">
                                                <option value="VIETTEL">VIETTEL</option>
                                                <option value="VINAPHONE">VINAPHONE</option>
                                                <option value="MOBIFONE">MOBIFONE</option>
                                                <option value="ZING">ZING</option>
                                                <option value="VNMOBI">VNMOBI</option>
                                            </select>
                                            <label class="form-label">Chọn Mệnh Giá Thẻ</label>
                                            <select name="menhgia" id="menhgia" class="form-control">
                                                <option value="10000">10.000</option>
                                                <option value="20000">20.000</option>
                                                <option value="30000">30.000</option>
                                                <option value="50000">50.000</option>
                                                <option value="100000">100.000</option>
                                                <option value="200000">200.000</option>
                                                <option value="300000">300.000</option>
                                                <option value="500000">500.000</option>
                                                <option value="1000000">1.000.000</option>
                                            </select>
                                            <label class="form-label">Nhập Số Seri Thẻ</label>
                                            <input type="text" class="form-control" id="seri" placeholder="Nhập Số Seri Thẻ">
                                            <label class="form-label">Nhập Mã Thẻ</label>
                                            <input type="text" class="form-control" id="pin" placeholder="Nhập Số Mã Thẻ">
                                            <button @click="napTheCao()" type="button" class="btn btn-success mt-3">Nạp Thẻ</button>
                                    </table>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-danger">
                        <b>Các Lưu Ý Khi Chuyển Khoản</b>
                    </div>
                    <div class="card-body text-center" style="margin: 4px">
                        <p><b>Chuyển Tiền Phải Đi Kèm Với Nội Dung Là</b></p>
                        <a v-if="get===1" href="#" class="text-primary"
                            @click="copyMa()"><b>@{{ ma }}</b></a>
                        <br>
                        <p>Trong 1-5 Phút Sau Khi Chuyển Khoản Mà Vẫn Chưa Nhận Được Tiền Thì Liên Hệ</p><a
                            href="https://www.facebook.com/binctp"> Ở Đây</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                status: 'Lấy Thông Tin Chuyển Khoản',
                get: 0,
                select: 0,
                ma: "BINCTP{{ Auth::guard('khach')->user()->username }}",
            },
            created() {

            },
            methods: {
                napTheCao(){
                    var data = {
                        'seri' : $("#seri").val() ? $("#seri").val() : null,
                        'type' : $("#type").val() ? $("#type").val() : null,
                        'menhgia' : $("#menhgia").val() ? $("#menhgia").val() : null,
                        'pin' : $("#pin").val() ? $("#pin").val() : null,
                    };
                    axios
                        .post('/autoTheCao', data)
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
                getChuyenKhoan() {
                    toastr.warning("Đang Lấy Thông Tin Chuyển Khoản");
                    this.status = "Đang Lấy Thông Tin....";
                    setTimeout(() => {
                        this.get = 1;
                        toastr.success("Lấy Thông Tin Chuyển Khoản Thành Công");
                    }, 3000);
                },
                copyMa() {
                    navigator.clipboard.writeText(this.ma)
                        .then(() => {
                            toastr.success("Copy Mã Thành Công");
                        })
                        .catch((error) => {
                            toastr.error("Có Lỗi Sãy Ra", error);
                        });
                }
            },
        });
    </script>
@endsection
