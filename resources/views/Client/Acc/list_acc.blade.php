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
    <!-- Favicon and touch icons  -->
    <link href="/assets_client/checkout/icon/logo.png" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Bootstrap  -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/bootstrap.css">

    <!-- Theme Style -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/style.css">
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/responsive.css">

    <!-- Colors -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/colors/color1.css" id="colors">

    <!-- Animation Style -->
    <link rel="stylesheet" type="text/css" href="/assets_client/checkout/stylesheets/animate.css">

    <style>
        .text-darkmod {
            background-color: #ffffff15;
            color: #7d8da1;
        }

        .rating-box {
            position: relative;

        }

        .rating-box header {
            font-size: 22px;
            color: #dadada;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: center;
        }

        .rating-box .stars {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stars i {
            color: #e6e6e6;
            font-size: 25px;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .stars i.active {
            color: #ff9c1a;
        }




        .comments-date {
            line-height: 1;
        }

        .commentator-name {
            font-weight: 500;
            font-size: 18px;
            line-height: 1;
            color: #000000;
            margin-bottom: 10px;
        }

        .comments-date {
            font-weight: 400;
            font-size: 12px;
            line-height: 18px;
            letter-spacing: 0.4px;
            color: #000000;
        }

        .comments {
            margin-top: 16px;
            font-weight: 400;
            font-size: 14px;
            line-height: 1.69;
            letter-spacing: 0.25px;
            color: #000000;
        }

        .btn-reply-text {
            font-weight: 400;
            font-size: 12px;
            line-height: 18px;
            letter-spacing: 0.4px;
            color: #000000;
            margin-top: 4px;
        }

        .btn-reply {
            margin-top: 16px;
        }

        .comments-img {
            width: 64px;
        }

        .comments-main {
            width: calc(100% - 64px);
            padding-left: 24px;
        }

        .comments-img img {
            width: 64px;
            height: 64px;
            border-radius: 100%;
            -o-object-fit: cover;
            object-fit: cover;
            -o-object-position: center;
            object-position: center;
        }

        .comments-item {
            margin-top: 48px;
        }

        .comment-form-area {
            background-color: #F0F1F2;
            padding: 64px;
            margin-top: 48px;
        }

        @media (max-width: 767px) {
            .comment-form-area {
                padding: 40px 20px;
            }
        }
    </style>
@endsection
@section('noi_dung')
    <main id="app">
        <section class="flat-row main-shop shop-detail style-1 mt-5">
            <div class="bd-container">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="slides">
                            <h2 class="product-title">Video Hướng Dẫn Cài Đặt
                            </h2>
                            <br>
                            <li data-thumb="{{ $data[0]->hinh_anh }}">
                                <img style="height: 400px;width: 100%;" src="{{ $data[0]->hinh_anh }}" alt="Image">
                                <div class="flat-icon style-2">
                                    <a href="{{ $data[0]->link2 }}" class="popup-video"><span
                                            class="fa fa-play"></span><span class="text bg-danger p-3 shadow">XEM VIDEO
                                            HƯỚNG DẪN CÀI ĐẶT</span></a>
                                </div>
                            </li>
                        </ul>
                    </div><!-- /.col-md-6 -->

                    <div class="col-md-6">
                        <div class="divider h0"></div>
                        <div class="product-detail">
                            <div class="inner">
                                <div class="content-detail">
                                    <h2 class="product-title">{{ $data[0]->ten_san_pham }}</h2>
                                    @php
                                        $rate = \App\Models\Rate::where('id_sp', $data[0]->id)->avg('rate');
                                        $starCount = floor($rate); // lấy số nguyên
                                        $halfStar = $rate - $starCount >= 0.5; // Kiểm tra nếu có nửa sao
                                        $totalRatings = \App\Models\Rate::where('id_sp', $data[0]->id)->count();
                                    @endphp
                                    {{-- <header class="text-success">Đánh Giá Sản Phẩm Này</header> --}}
                                    <template>
                                        <div v-if="rating == 1" class="flat-star style-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $starCount)
                                                    <i class="fa fa-star" style="color: #ff9c1a;"></i>
                                                @elseif($halfStar)
                                                    <i class="fa fa-star-half-o"></i>
                                                    @php $halfStar = false; @endphp
                                                @else
                                                    <i class="fa fa-star" style="color: #ffffff;"></i>
                                                @endif
                                            @endfor
                                            <span>({{ $totalRatings }})</span>
                                            <a href="#" @click="rating=0" class="text-success">Đánh Giá Sản Phẩm
                                                Này</a>
                                        </div>
                                        <div v-else class="rating-box mt-1">
                                            <div class="stars">
                                                <i @click="rate(1,{{ $data[0]->id }})" class="fa-solid fa-star"></i>
                                                <i @click="rate(2,{{ $data[0]->id }})" class="fa-solid fa-star"></i>
                                                <i @click="rate(3,{{ $data[0]->id }})" class="fa-solid fa-star"></i>
                                                <i @click="rate(4,{{ $data[0]->id }})" class="fa-solid fa-star"></i>
                                                <i @click="rate(5,{{ $data[0]->id }})" class="fa-solid fa-star"></i>
                                            </div>
                                        </div>
                                    </template>
                                    {{-- <p>{{ $data[0]->mo_ta }}</p> --}}
                                    @php
                                        $chucNang = explode('@', $data[0]->mo_ta);
                                    @endphp
                                    <ul class="product-infor style-1">
                                        @foreach ($chucNang as $value)
                                            <li><span>{{ $value }}</span></li>
                                        @endforeach
                                    </ul>
                                    <div class="product-categories margin-top-22">
                                        <span>Tags : </span><a href="#">{{ $slug_chuyen_muc }}</a> , <a
                                            href="#">{{ $slug_danh_muc }}</a>
                                        <br>
                                        <span>Số Lượng Acc Còn Lại :</span> <a href="#">{{$count}}</a>
                                    </div>

                                    <form id="formdata" v-on:submit.prevent="checkout()">
                                        <div class="product-quantity margin-top-35">
                                            @php
                                                $check = [];
                                            @endphp

                                            <div>
                                                <select name="id_pack">
                                                    @foreach ($data as $value)
                                                        @if (!in_array($value->thoi_gian, $check))
                                                            <option value="{{ $value->id_pack }}">
                                                                @php
                                                                    $gia_ban = number_format($value->gia_ban, 0, ',', '.') . '₫';
                                                                @endphp
                                                                {{ $gia_ban }} / 1 Acc</option>
                                                            @php
                                                                $check[] = $value->thoi_gian;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="quantity">
                                                <input type="text" :value="number" name="number"
                                                    class="quantity-number">
                                                <span @click="number++" class="inc quantity-button">+</span>
                                                <span @click="number--" class="dec quantity-button">-</span>
                                            </div>
                                            <input name="id" type="hidden" value="{{ $data[0]->id }}">
                                            <div class="add-to-cart">
                                                {{-- <a href="/checkout">Mua Ngay</a> --}}
                                                <button type="submit">Mua Ngay</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.product-detail -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section>

        <section class="flat-row shop-related">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title-section margin-bottom-55">
                            <h2 class="product-title">Sản Phẩm Liên Quan</h2>
                        </div>
                        @if (count($dsSanPhamLienQuan) > 0)
                            <div class="product-content product-fourcolumn clearfix">
                                <ul class="product style2">
                                    @foreach ($dsSanPhamLienQuan as $value)
                                        <li class="product-item">
                                            <div class="product-thumb clearfix" style="max-height: 200px;">
                                                <a
                                                    href="{{ route('sanPham', ['slug_chuyen_muc' => $slug_chuyen_muc, 'slug_danh_muc' => $slug_danh_muc, 'id_san_pham' => $value['id']]) }}">
                                                    <img src="{{ $value['hinh_anh'] }}" alt="image">
                                                </a>
                                            </div>
                                            <div class="product-info clearfix mt-2">
                                                <span class="product-title">{{ $value['ten_san_pham'] }}</span>
                                                @php
                                                    $a = explode('@', $value['mo_ta']);
                                                @endphp
                                                <ul class="product-infor style-1">
                                                    @foreach ($a as $p)
                                                        <li><span>{{ $p }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="add-to-cart text-center">
                                                @if ($slug_chuyen_muc == 'tai-khoan-tiktok')
                                                    <a
                                                        href='/tiktok/{{ $slug_chuyen_muc }}/{{ $slug_danh_muc }}/{{ $value['id'] }}'>
                                                        Xem Ngay
                                                    </a>
                                                @else
                                                    <a
                                                        href='{{ route('sanPham', ['slug_chuyen_muc' => $slug_chuyen_muc, 'slug_danh_muc' => $slug_danh_muc, 'id_san_pham' => $value['id']]) }}'>
                                                        Xem Ngay
                                                    </a>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul><!-- /.product -->
                            </div><!-- /.product-content -->
                        @else
                            <div class="text-center">
                                <h3 class="text-success">Opps ! Không Tìm Thấy Sản Phẩm Nào Liên Quan</h3>
                            </div>
                        @endif

                    </div>
                </div><!-- /.row -->
            </div>
        </section>

        {{-- Đánh Giá  --}}
        <section class="flat-row flat-contact" loading="lazy">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title-section margin_bottom_17">
                            <h2 class="product-title">
                                Đánh Giá Sản Phẩm <br>
                                <span class="text-danger">{{ $data[0]->ten_san_pham }}</span>
                            </h2>
                        </div><!-- /.title-section -->
                    </div><!-- /.col-md-12 -->
                </div><!-- /.row -->
                <div class="row">
                    <div class="comments-section mt-100 home-section overflow-hidden">
                        <div class="section-header">
                            <h2 class="section-heading">Tất Cả Đánh Giá - @{{ listDanhGia.length ? listDanhGia.length : 'Chưa Có Đánh Giá' }}</h2>
                        </div>
                        <div class="comments-area" v-if="listDanhGia.length>0">
                            <div v-for="(v,k) in listDanhGia" class="d-flex comments-item">
                                <div class="comments-img">
                                    <img src="/assets_client/img/avatar.ico" alt="img">
                                </div>
                                <div class="comments-main">
                                    <div class="comments-main-content">
                                        <div class="comments-meta">
                                            <template>
                                                <h4 v-if="v.ownComment==1" class="commentator-name">
                                                    @{{ v.name }} - ( Bạn )</h4>
                                                <h4 v-else class="commentator-name"> @{{ v.name }} </h4>
                                            </template>
                                            <div class="flat-star style-1">
                                                <i v-for="i in v.rate" class="fa fa-star"></i>
                                            </div>
                                            <div class="comments-date article-date d-flex align-items-center">
                                                <span class="icon-publish">
                                                    <svg width="17" height="18" viewBox="0 0 17 18"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M3.46875 0.875V1.59375H0.59375V17.4063H16.4063V1.59375H13.5313V0.875H12.0938V1.59375H4.90625V0.875H3.46875ZM2.03125 3.03125H3.46875V3.75H4.90625V3.03125H12.0938V3.75H13.5313V3.03125H14.9688V4.46875H2.03125V3.03125ZM2.03125 5.90625H14.9688V15.9688H2.03125V5.90625ZM6.34375 7.34375V8.78125H7.78125V7.34375H6.34375ZM9.21875 7.34375V8.78125H10.6563V7.34375H9.21875ZM12.0938 7.34375V8.78125H13.5313V7.34375H12.0938ZM3.46875 10.2188V11.6563H4.90625V10.2188H3.46875ZM6.34375 10.2188V11.6563H7.78125V10.2188H6.34375ZM9.21875 10.2188V11.6563H10.6563V10.2188H9.21875ZM12.0938 10.2188V11.6563H13.5313V10.2188H12.0938ZM3.46875 13.0938V14.5313H4.90625V13.0938H3.46875ZM6.34375 13.0938V14.5313H7.78125V13.0938H6.34375ZM9.21875 13.0938V14.5313H10.6563V13.0938H9.21875Z"
                                                            fill="#00234D"></path>
                                                    </svg>
                                                </span>
                                                <span class="ms-2"> @{{ v.created_at_formatted }} </span>
                                            </div>
                                            <p class="comments"> @{{ v.noi_dung }} </p>
                                            <a href="" v-if="v.ownComment==1"
                                                v-on:click.prevent="remove(v.id,v.id_sp)"><u>remove</u></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item" :class="{ 'disabled': !pagination.prev_page_url }">
                                        <a class="page-link" href="#"
                                            v-on:click.prevent="load(pagination.current_page - 1)">Trang Trước</a>
                                    </li>
                                    <li class="page-item" :class="{ 'disabled': !pagination.next_page_url }">
                                        <a class="page-link" href="#"
                                            v-on:click.prevent="load(pagination.current_page + 1)">Trang Kế</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="comment-form-area">
                            <div class="form-header">
                                <h4 class="form-title">Đánh Giá</h4>
                                <p class="form-subtitle">Để lại phản hồi của bạn</p>
                            </div>
                            <form v-on:submit.prevent="guiDanhGia()" id="formDanhGia">
                                <input type="hidden" value="{{ $data[0]->id }}" name="id_san_pham">
                                <div class="name-email-field d-flex justify-content-between">
                                    <div class="field-item name-field">
                                        <span class="field-icon">
                                            <svg width="16" height="18" viewBox="0 0 16 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8 0.75C5.1084 0.75 2.75 3.1084 2.75 6C2.75 7.80762 3.67285 9.41309 5.07031 10.3594C2.39551 11.5078 0.5 14.1621 0.5 17.25H2C2 13.9277 4.67773 11.25 8 11.25C11.3223 11.25 14 13.9277 14 17.25H15.5C15.5 14.1621 13.6045 11.5078 10.9297 10.3594C12.3271 9.41309 13.25 7.80762 13.25 6C13.25 3.1084 10.8916 0.75 8 0.75ZM8 2.25C10.0801 2.25 11.75 3.91992 11.75 6C11.75 8.08008 10.0801 9.75 8 9.75C5.91992 9.75 4.25 8.08008 4.25 6C4.25 3.91992 5.91992 2.25 8 2.25Z"
                                                    fill="#00234D"></path>
                                            </svg>
                                        </span>
                                        <input type="text" placeholder="Nhập Tên Của Bạn" required name="name"
                                            v-model="name">
                                    </div>
                                </div>
                                <div class="field-item textarea-field">
                                    <span class="field-icon">
                                        <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.25 0.75V14.25H4V18.0586L8.76367 14.25H19.75V0.75H0.25ZM1.75 2.25H18.25V12.75H8.23633L5.5 14.9385V12.75H1.75V2.25ZM5.5 6C4.6709 6 4 6.6709 4 7.5C4 8.3291 4.6709 9 5.5 9C6.3291 9 7 8.3291 7 7.5C7 6.6709 6.3291 6 5.5 6ZM10 6C9.1709 6 8.5 6.6709 8.5 7.5C8.5 8.3291 9.1709 9 10 9C10.8291 9 11.5 8.3291 11.5 7.5C11.5 6.6709 10.8291 6 10 6ZM14.5 6C13.6709 6 13 6.6709 13 7.5C13 8.3291 13.6709 9 14.5 9C15.3291 9 16 8.3291 16 7.5C16 6.6709 15.3291 6 14.5 6Z"
                                                fill="#00234D"></path>
                                        </svg>
                                    </span>
                                    <textarea v-model="noi_dung" name="noi_dung" cols="20" rows="6"
                                        placeholder="Viết Bình Luận Của Bạn Ở Đây........"></textarea>
                                </div>
                                <button type="submit" class="position-relative review-submit-btn mt-4 btn-primary">Gửi
                                    Đánh Giá</button>
                            </form>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section>


    </main>
@endsection
@section('js')
    <script src="/assets_client/checkout/javascript/jquery.min.js"></script>
    <script src="/assets_client/checkout/javascript/tether.min.js"></script>
    <script src="/assets_client/checkout/javascript/bootstrap.min.js"></script>
    <script src="/assets_client/checkout/javascript/jquery.easing.js"></script>
    <script src="/assets_client/checkout/javascript/parallax.js"></script>
    <script src="/assets_client/checkout/javascript/jquery-waypoints.js"></script>
    <script src="/assets_client/checkout/javascript/jquery-countTo.js"></script>
    <script src="/assets_client/checkout/javascript/jquery.countdown.js"></script>
    <script src="/assets_client/checkout/javascript/jquery.flexslider-min.js"></script>
    <script src="/assets_client/checkout/javascript/images-loaded.js"></script>
    <script src="/assets_client/checkout/javascript/jquery.isotope.min.js"></script>
    <script src="/assets_client/checkout/javascript/magnific.popup.min.js"></script>
    <script src="/assets_client/checkout/javascript/jquery.hoverdir.js"></script>
    <script src="/assets_client/checkout/javascript/owl.carousel.min.js"></script>
    <script src="/assets_client/checkout/javascript/equalize.min.js"></script>
    <script src="/assets_client/checkout/javascript/gmap3.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIEU6OT3xqCksCetQeNLIPps6-AYrhq-s&region=GB"></script>
    <script src="/assets_client/checkout/javascript/jquery-ui.js"></script>

    <script src="/assets_client/checkout/javascript/jquery.cookie.js"></script>
    <script src="/assets_client/checkout/javascript/main.js"></script>

    <!-- Revolution Slider -->
    <script src="/assets_client/checkout/rev-slider/js/jquery.themepunch.tools.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/jquery.themepunch.revolution.min.js"></script>
    <script src="/assets_client/checkout/javascript/rev-slider.js"></script>
    <!-- Load Extensions only on Local File Systems ! The following part can be removed on Server for On Demand Loading -->
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.carousel.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.parallax.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="/assets_client/checkout/rev-slider/js/extensions/revolution.extension.video.min.js"></script>
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
                number: 1,
                rating: 1,
                listDanhGia: [],
                pagination: null,
                name: null,
                noi_dung: null,
            },
            created() {
                this.load(1);
            },
            methods: {
                remove(id, id_sp) {
                    var data = {
                        'id': id,
                        'id_sp': id_sp,
                    };
                    axios
                        .post('/removeDanhGia/' + id, data)
                        .then((res) => {
                            if (res.data.status) {
                                this.load(1);
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
                load(page) {
                    var data = {
                        'id': @json($data[0]->id),
                    };
                    axios
                        .post('/danhGiaData?page=' + page, data)
                        .then((res) => {
                            if (res.data.status) {
                                this.listDanhGia = res.data.data.data;
                                this.pagination = res.data.data;
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                guiDanhGia() {
                    var paramObj = {};
                    $.each($('#formDanhGia').serializeArray(), function(_, kv) {
                        if (paramObj.hasOwnProperty(kv.name)) {
                            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                            paramObj[kv.name].push(kv.value);
                        } else {
                            paramObj[kv.name] = kv.value;
                        }
                    });
                    axios
                        .post('/guiDanhGia', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                this.load(1);
                                this.name = null;
                                this.noi_dung = null;
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
                rate(num, id_san_pham) {
                    var data = {
                        'rate': num,
                        'id': id_san_pham,
                    };
                    axios
                        .post('/rate', data)
                        .then((res) => {
                            if (res.data.status) {
                                this.rating = 1;
                                toastr.success(res.data.message);
                            } else {
                                this.rating = 1;
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                checkout() {
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
                        .post('/checkout/tiktok', paramObj)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                window.location.href = "/history";
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
            },
        });
    </script>
    <script>
        // Select all elements with the "i" tag and store them in a NodeList called "stars"
        const stars = document.querySelectorAll(".stars i");

        // Loop through the "stars" NodeList
        stars.forEach((star, index1) => {
            // Add an event listener that runs a function when the "click" event is triggered
            star.addEventListener("click", () => {
                // Loop through the "stars" NodeList Again
                stars.forEach((star, index2) => {
                    // Add the "active" class to the clicked star and any stars with a lower index
                    // and remove the "active" class from any stars with a higher index
                    index1 >= index2 ? star.classList.add("active") : star.classList.remove(
                        "active");
                });
            });
        });
    </script>
@endsection
