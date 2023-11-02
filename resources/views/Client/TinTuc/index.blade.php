@extends('Client.home_page')
@section('css')
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="/assets_client/card/css/swiper-bundle.min.css">
    <style>
        .container h2 {
            letter-spacing: 1px;
            font-size: 50px;
            color: #6968aa;
            border: 2px dashed #0181a0;
            padding: 10px;
            text-transform: uppercase;
            border-radius: 10px;
            display: inline-block;
            cursor: pointer;
            text-align: center;
            margin-top: 90px;
            margin-left: 375px;
        }

        .blog-post {
            width: 100%;
            max-width: 98rem;
            padding: 5rem;
            background-color: #dbf4ff21;
            box-shadow: 0 1.4rem 8rem rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            border-radius: .8rem;
            margin: 10px;
        }

        .blog-post_img {
            min-width: 35rem;
            max-width: 35rem;
            height: 30rem;
            transform: translateX(-8rem);
            position: relative;
        }

        .blog-post_img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: .8rem;
            display: block;
        }

        .blog-post_img img::before {
            content: '';
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            box-shadow: .5rem .5rem 3rem 1px rgba(0, 0, 0, 0.5);
            border-radius: .8rem;
        }

        .blog-post_date span {
            display: block;
            color: #00000080;
            font-size: 1.6rem;
            font-weight: 600;
            margin: .5rem 0;
        }

        .blog-post_title {
            font-size: 1.6rem;
            margin: 1.5rem 0 2rem;
            text-transform: uppercase;
            color: #4facfe;
        }

        .blog-post_text {
            margin-bottom: 2.4rem;
            font-size: 1rem;
            color: #000000b3;
        }

        .blog-post_cta {
            display: inline-block;
            padding: 0.7rem 1.5rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 1.2rem;
            color: #fff;
            text-decoration: none;
            border-radius: .8rem;
            background: linear-gradient(to right, #c945cf 0%, #04a6bd 100%);
        }

        .blog-post_cta:hover {
            background: linear-gradient(to right, #04a6bd 0%, #c945cf 100%);
        }

        @media screen and (max-width: 1068px) {
            .blog-post {
                max-width: 80rem;
            }

            .blog-post_img {
                min-width: 30rem;
                max-width: 30rem;
            }

            .container h2 {
                margin-top: 120px;
                margin-left: 275px;
            }
        }

        @media screen and (max-width: 868px) {
            .blog-post {
                max-width: 70rem;
            }

            .container h2 {
                margin-top: 20px;
                margin-left: 142px;
            }
        }

        @media screen and (max-width: 768px) {
            .blog-post {
                padding: 2.5rem;
                flex-direction: column;
            }

            .blog-post_img {
                min-width: 100%;
                max-width: 100%;
                transform: translate(0, -1rem);
            }

            .container {
                margin-top: auto;
            }
        }

        @media screen and (max-width: 823px) {
            .container h2 {
                margin-top: 35px;
                margin-left: 142px;
            }
        }
    </style>
@endsection
@section('noi_dung')
    <section class="accessory section bd-container" loading='lazy'>
        @foreach ($data as $value)
            <div class="blog-post">
                <div class="blog-post_img">
                    <img src="{{ $value->hinh_anh }}" alt="">
                </div>
                <div class="blog-post_info">
                    <div class="blog-post_date">
                        <span>TikTok</span>
                        <span>{{ $value->date }}</span>
                    </div>
                    <h1 class="blog-post_title">{{ $value->title }}</h1>
                    <p class="blog-post_text">{{ $value->content }}</p>
                    <a href="{{$value->link}}" class="blog-post_cta">Xem Thêm</a>
                </div>
            </div>
        @endforeach
    </section>
    <nav aria-label="Page navigation" class="mb-4">
        <ul class="pagination justify-content-center">
            {{ $data->links() }}
        </ul>
    </nav>
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
@endsection
