<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    @yield('css')
    <!--========== CSS ==========-->
    <link rel="stylesheet" href="/assets_client/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>BinTP.COM Chuyên Cung Cấp Dịch Vụ Về TikTok</title>


</head>

<body>
    <!-- Modal -->

    <!--========== SCROLL TOP ==========-->
    <a href="#" class="scrolltop" id="scroll-top">
        <i class='bx bx-up-arrow-alt scrolltop__icon'></i>
    </a>

    <!--========== HEADER ==========-->
    <header class="l-header" id="header">
        <nav class="nav bd-container">
            <h2><a href="/" class="nav__logo">BINCTP.COM</a></h2>
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    {{-- <li class="nav__item"><a href="/#taiKhoan" class="nav__link active-link">Tài Khoản</a></li>
                    <li class="nav__item"><a href="/#coinTikTok" class="nav__link">Xu Rương</a></li> --}}
                    <li class="nav__item"><a href="/#sanPham" class="nav__link">Game Mod</a></li>
                    <li class="nav__item"><a href="/#accordion" class="nav__link">FAQ</a></li>
                    <li class="nav__item"><a href="/tin-tuc" class="nav__link">Tin Tức</a></li>
                    <li class="nav__item"><a href="/naptien" class="nav__link">Nạp Thẻ</a></li>
                    <li class="nav__item"><a href="/info" class="nav__link">Thông Tin</a>
                    </li>
                    @if (!Auth::guard('khach')->check())
                        <li class="nav__item"><a href="/login" class="nav__link">Đăng Nhập</a></li>
                    @endif
                    {{-- <li><i class='bx bx-toggle-left change-theme' id="theme-button"></i></li> --}}
                </ul>
            </div>

            <div class="nav__toggle" id="nav-toggle">
                <i class='bx bx-grid-alt'></i>
            </div>
        </nav>
    </header>
    <main class="l-main">
        @yield('noi_dung')
    </main>

    <!--========== FOOTER ==========-->
    <footer class="footer section" loading="lazy">
        <div class="footer__container bd-container bd-grid" style="margin: auto;">
            <div class="footer__content">
                <h3 class="footer__title">
                    <a href="#" class="footer__logo">BinCtp.Com</a>
                </h3>
                <p class="footer__description">Chuyên cung cấp các dịch vụ tiktok Và Game Mobile Mod</p>
            </div>
            <div class="footer__content">
                <h3 class="footer__title">Liên Hệ</h3>
                <ul>
                    <li><a href="#" class="footer__link">Facebook</a></li>
                    <li><a href="#" class="footer__link">Zalo</a></li>
                </ul>
            </div>
            <div class="footer__content">
                <h3 class="footer__title">Dịch Vụ</h3>
                <ul>
                    <li><a href="/#sanPham" class="footer__link">Game Mod</a></li>
                    <li><a href="/#" class="footer__link">Acc TikTok</a></li>
                </ul>
            </div>

            <div class="footer__content">
                <h3 class="footer__title">Khác</h3>
                <a href="#" class="footer__social"><i class='bx bxl-facebook-circle '></i></a>
                <a href="#" class="footer__social"><i class='bx bxl-twitter'></i></a>
                <a href="#" class="footer__social"><i class='bx bxl-instagram-alt'></i></a>
            </div>
        </div>
        <br>
        <p class="footer__copy">&#169; 2023 Chung Tuấn Phát. All right reserved</p>
    </footer>

    <!--========== SCROLL REVEAL ==========-->
    <script src="https://unpkg.com/scrollreveal"></script>

    <!--========== MAIN JS ==========-->
    <script src="/assets_client/js/main.js"></script>

    @yield('js')
</body>

</html>
