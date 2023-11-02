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
    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/style.css">
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/responsive.css">
    <!-- Colors -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/colors/color1.css" id="colors">
    <!-- Animation Style -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/animate.css">
@endsection
@section('noi_dung')
    <section class="accessory section bd-container" id="app">
        <h2 class="section-title">Lịch Sử Mua Hàng</h2>
        <form>
            Lọc Sản Phẩm : <input class="form-control text-center text-darkmod" type="text" value="{{ $search }}"
                placeholder="Nhập Tên Sản Phẩm" name="q">
        </form>
        <table class="table table-bordered">
            <tr>
                <td class="text-center">#</td>
                <td class="text-center">Tên</td>
                <td class="text-center">Info</td>
                <td class="text-center">Ngày Mua</td>
            </tr>
            @foreach ($history as $key => $value)
                <tr>
                    <th class="text-center">{{ $key + 1 }}</th>
                    <th class="text-center">{{ $value->ten_san_pham }}</th>
                    <th class="text-center">
                        <button v-on:click="downloadInfo({{ $value->type }})" class="btn btn-danger">Tải Về</button>
                        <button v-on:click="chiTiet({{ $value->type }})" type="button" class="btn btn-success"
                            data-bs-toggle="modal" data-bs-target="#infoo">
                            Chi Tiết
                        </button>
                    </th>
                    <th class="text-center">{{ $value->ngay_mua }}</th>
                </tr>
            @endforeach
        </table>

        <div class="modal fade" id="infoo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-darkmod" id="exampleModalLabel">Chi Tiết</h5>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tr>
                                <td class="text-center bold-text">#</td>
                                <td class="text-center bold-text">Key</td>
                            </tr>
                            <tr v-for="(v,k) in listChiTiet">
                                <td class="text-center bold-text">@{{ k + 1 }}</td>
                                <td class="text-center bold-text">@{{ v.key }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
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
                listChiTiet: [],
            },
            created() {

            },
            methods: {
                chiTiet(value) {
                    axios.post('/history/download/' + value)
                        .then((res) => {
                            if (res.data.status) {
                                this.listChiTiet = res.data.data;
                            }
                        })
                        .catch((error) => {
                            console.error(error);
                            toastr.error('An error occurred.');
                        });
                },
                downloadInfo(value) {
                    axios.post('/history/download/' + value)
                        .then((res) => {
                            if (res.data.status) {
                                this.downloadData(res.data.data);
                                toastr.success(res.data.message);
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((error) => {
                            console.error(error);
                            toastr.error('An error occurred.');
                        });
                },
                downloadData(data) {
                    let text = '';
                    data.forEach(item => {
                        const {
                            key
                        } = item;
                        if (key.includes('|')) {
                            const [username, password] = key.split('|');
                            text += `${username} | ${password}\n`;
                        } else {
                            text += `${key}\n`;
                        }
                    });

                    const blob = new Blob([text], {
                        encoding:"UTF-8",
                        type:"text/plain;charset=UTF-8"
                    });

                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = 'data.txt';

                    document.body.appendChild(link);
                    link.click();

                    URL.revokeObjectURL(url);
                    link.remove();
                }
            },
        });
    </script>
@endsection
