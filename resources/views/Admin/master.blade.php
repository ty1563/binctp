<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/style.css">
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
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .form-control,
        table,
        tr,
        th,
        td {
            border-radius: 10px;
        }

        .card {
            border: none;
        }

        body,
        p,
        a,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        span,
        div {
            text-decoration: none !important;
        }

        .bold-text {
            font-weight: bold;
        }

        .text-darkmod {
            background-color: #ffffff15;
            color: #7d8da1;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            background-color: #ffffff15;
            color: #7d8da1;
            padding: 5px;
        }
    </style>
    @yield('css')
    <title>Admin Quản Lý | Panel</title>
</head>

<body>

    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="/images/logo.png">
                    <h2>TikTok<span class="danger">Coin</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>

            <div class="sidebar">
                @php
                    $quyen = Auth::guard('admin')->user()->id_quyen;
                    $quyenArr = explode(',', $quyen);
                    $isMaster = in_array('is_master', $quyenArr);
                @endphp

                <a href="/admin" class="menu-link">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Thống Kê</h3>
                </a>
                @if (in_array('quyen_chuyen_muc', $quyenArr) || $isMaster)
                    <a href="/admin/chuyen-muc/" class="menu-link">
                        <span class="material-icons-sharp">
                            insights
                        </span>
                        <h3>Chuyên Mục</h3>
                    </a>
                @endif

                @if (in_array('quyen_danh_muc', $quyenArr) || $isMaster)
                    <a href="/admin/danh-muc" class="menu-link">
                        <span class="material-symbols-outlined">
                            receipt_long
                        </span>
                        <h3>Danh Mục</h3>
                    </a>
                @endif
                @if (in_array('quyen_khach_hang', $quyenArr) || $isMaster)
                    <a href="/admin/khach-hang" class="menu-link">
                        <span class="material-icons-sharp">
                            person_outline
                        </span>
                        <h3>Khách Hàng</h3>
                    </a>
                @endif
                @if (in_array('quyen_lich_su', $quyenArr) || $isMaster)
                    <a href="/admin/lichsu" class="menu-link">
                        <span class="material-icons-sharp">
                            receipt_long
                        </span>
                        <h3>Lịch Sử</h3>
                    </a>
                @endif

                @if (in_array('quyen_san_pham', $quyenArr) || $isMaster)
                    <a href="/admin/san-pham" class="menu-link">
                        <span class="material-symbols-outlined">
                            category
                        </span>
                        <h3>Sản Phẩm</h3>
                    </a>
                @endif

                @if (in_array('quyen_key', $quyenArr) || $isMaster)
                    <a href="/admin/pack" class="menu-link">
                        <span class="material-symbols-outlined">
                            storefront
                        </span>
                        <h3>Quản Lý Key</h3>
                    </a>
                @endif
                @if (in_array('quyen_setting', $quyenArr) || $isMaster)
                    <a href="/admin/setting" class="menu-link">
                        <span class="material-symbols-outlined">
                            settings
                        </span>
                        <h3>Setting</h3>
                    </a>
                @endif
                @if (in_array('quyen_info', $quyenArr) || $isMaster)
                    <a href="/admin/thong-tin" class="menu-link">
                        <span class="material-symbols-outlined">
                            badge
                        </span>
                        <h3>Thông Tin</h3>
                    </a>
                @endif
                @if (in_array('quyen_question', $quyenArr) ||$isMaster)
                    <a href="/admin/question" class="menu-link">
                        <span class="material-symbols-outlined">
                            quiz
                        </span>
                        <h3>Hỏi & Trả Lời</h3>
                    </a>
                @endif
                @if (in_array('quyen_tintuc', $quyenArr) ||$isMaster)
                    <a href="/admin/tin-tuc" class="menu-link">
                        <span class="material-symbols-outlined">
                            feed
                        </span>
                        <h3>Tin Tức</h3>
                    </a>
                @endif
                @if(in_array('quyen_admin', $quyenArr) || $isMaster)
                <a href="/admin/admin" class="menu-link">
                    <span class="material-icons-sharp">
                        add
                    </span>
                    <h3>Thêm Admin</h3>
                </a>
                @endif

                @if (Auth::guard('admin')->check())
                <a href="/admin/panel-game" class="menu-link">
                    <span class="material-symbols-outlined">
                        stadia_controller
                        </span>
                    <h3>Game Panel</h3>
                </a>
                    <a style="color: red;" href="/admin/logout" class="menu-link">
                        <span class="material-icons-sharp">
                            logout
                        </span>
                        <h3>Đăng Xuất</h3>
                    </a>
                @endif
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            {{-- search  --}}

            {{-- search  --}}
            <div class="analyse">
                @yield('noi_dung')
            </div>

        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>

                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>
                @if (Auth::guard('admin')->check())
                    <div class="profile">
                        <div class="info">
                            <p>Hey, <b>{{ Auth::guard('admin')->user()->username }}</b></p>
                            <small class="text-muted">Admin</small>
                        </div>
                        {{-- <div class="profile-photo">
                        <img src="/images/profile-1.jpg">
                    </div> --}}
                    </div>
                @else
                    <span class="text-darkmod">Đăng Nhập</span>
                @endif

            </div>
            <!-- End of Nav -->

            <div class="user-profile">
                <div class="logo">
                    <img src="/images/logo.png">
                    <h2>BinTp</h2>
                    <p>TikTok Coins</p>
                </div>
            </div>

            <div class="reminders">
                <div class="header">
                    <h2>Tình Trạng</h2>
                </div>

                <div class="notification">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            volume_up
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Số Acc Đang Bán</h3>
                            <small class="text_muted">
                                100.000
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>

                <div class="notification deactive">
                    <div class="icon">
                        <span class="material-icons-sharp">
                            edit
                        </span>
                    </div>
                    <div class="content">
                        <div class="info">
                            <h3>Số Key Còn Lại</h3>
                            <small class="text_muted">
                                156 Acc
                            </small>
                        </div>
                        <span class="material-icons-sharp">
                            more_vert
                        </span>
                    </div>
                </div>

                {{-- <div class="notification add-reminder">
                    <div>
                        <span class="material-icons-sharp">
                            add
                        </span>
                        <h3>Add Reminder</h3>
                    </div>
                </div> --}}

            </div>

        </div>


    </div>



    <script>
        const menuLinks = document.querySelectorAll('.menu-link');

        menuLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                // event.preventDefault(); // Ngăn chuyển hướng mặc định

                // // Xóa lớp "active" từ thẻ trước đó
                menuLinks.forEach(menuLink => {
                    menuLink.classList.remove('active');
                });

                // Thêm lớp "active" vào thẻ được nhấp vào
                link.classList.add('active');
            });
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

    <script src="/index.js"></script>
    @yield('js')
</body>

</html>
