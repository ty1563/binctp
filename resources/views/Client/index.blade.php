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


    <!--=============== CSS ===============-->
    <style>
        .accordion .accordion-content {
            margin: 10px 0;
            border-radius: 4px;
            background: #FFF7F0;
            border: 1px solid #FFD6B3;
            overflow: hidden;
        }

        .accordion-content:nth-child(2) {
            background-color: #F0FAFF;
            border-color: #CCEEFF;
        }

        .accordion-content:nth-child(3) {
            background-color: #FFF0F3;
            border-color: #FFCCD6;
        }

        .accordion-content:nth-child(4) {
            background-color: #F0F0FF;
            border-color: #CCCCFF;
        }

        .accordion-content.open {
            padding-bottom: 10px;
        }

        .accordion-content header {
            display: flex;
            min-height: 50px;
            padding: 0 15px;
            cursor: pointer;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s linear;
        }

        .accordion-content.open header {
            min-height: 35px;
        }

        .accordion-content header .title {
            font-size: 17px;

            font-weight: 600;
            color: #333;
        }

        .accordion-content header i {
            font-size: 15px;
            color: #333;
        }

        .accordion-content .description {
            height: 0;
            font-size: 14px;
            color: #333;
            font-weight: 400;
            padding: 0 15px;
            transition: all 0.2s linear;
        }
    </style>
    {{-- MODAL  --}}
    <style>
        .view-modal {
            top: 50%;
            color: #7d2ae8;
            font-size: 18px;
            padding: 10px 25px;
            background: #fff;
            transform: translate(-50%, -50%);
        }

        .popup {
            background: #ffffff;
            padding: 25px;
            border-radius: 15px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 500px;
            width: 100%;
            opacity: 0;
            pointer-events: none;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
            transition: top 0s 0.2s ease-in-out, opacity 0.2s 0s ease-in-out, transform 0.2s 0s ease-in-out;

            position: fixed;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transform-style: preserve-3d;
            perspective: 1000px;
            z-index: 9999;
        }

        .popup.show {
            top: 50%;
            opacity: 1;
            pointer-events: auto;
            transform: translate(-50%, -50%) scale(1);
            transition: top 0s 0s ease-in-out,
                opacity 0.2s 0s ease-in-out,
                transform 0.2s 0s ease-in-out;

        }

        .popup :is(header, .icons, .field) {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .popup header {
            padding-bottom: 15px;
            border-bottom: 1px solid #ebedf9;
        }

        .close,
        .icons a,
        .remove {
            display: flex;
            align-items: center;
            border-radius: 10%;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }

        .icons a {
            display: flex;
            align-items: center;
            border-radius: 50%;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }


        .remove {
            color: #ff0000;
            font-size: 17px;
            background: #ffffff;
            height: 33px;
            width: 33px;
            cursor: pointer;
        }

        .remove:hover {
            background: #e85553;
        }

        .close {
            color: #000000;
            font-size: 17px;
            background: #fefefe;
            height: 33px;
            width: 33px;
            cursor: pointer;
        }

        .close:hover {
            background: #77b629;
        }

        .popup .content {
            margin: 20px 0;
        }

        .popup .icons {
            margin: 15px 0 20px 0;
        }

        .content p {
            font-size: 16px;
        }

        .content .icons a {
            height: 50px;
            width: 50px;
            font-size: 20px;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .icons a i {
            transition: transform 0.3s ease-in-out;
        }

        .icons a:nth-child(1) {
            color: #1877F2;
            border-color: #b7d4fb;
        }

        .icons a:nth-child(1):hover {
            background: #1877F2;
        }

        .icons a:nth-child(2) {
            color: #46C1F6;
            border-color: #b6e7fc;
        }

        .icons a:nth-child(2):hover {
            background: #46C1F6;
        }

        .icons a:nth-child(3) {
            color: #e1306c;
            border-color: #f5bccf;
        }

        .icons a:nth-child(3):hover {
            background: #e1306c;
        }

        .icons a:nth-child(4) {
            color: #25D366;
            border-color: #bef4d2;
        }

        .icons a:nth-child(4):hover {
            background: #25D366;
        }

        .icons a:nth-child(5) {
            color: #0088cc;
            border-color: #b3e6ff;
        }

        .icons a:nth-child(5):hover {
            background: #0088cc;
        }

        .icons a:hover {
            color: #fff;
            border-color: transparent;
        }

        .icons a:hover i {
            transform: scale(1.2);
        }

        .content .field {
            margin: 12px 0 -5px 0;
            height: 45px;
            border-radius: 4px;
            padding: 0 5px;
            border: 1px solid #e1e1e1;
        }

        .field.active {
            border-color: #7d2ae8;
        }

        .field i {
            width: 50px;
            font-size: 18px;
            text-align: center;
        }

        .field.active i {
            color: #7d2ae8;
        }

        .field input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            font-size: 15px;
        }

        .field button {
            color: #fff;
            padding: 5px 18px;
            background: #7d2ae8;
        }

        .field button:hover {
            background: #8d39fa;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="/assets_client/card/css/styles.css">
@endsection
@section('noi_dung')
    @php
        $listBanner = \App\Models\ClientSetting::join('chuyen_mucs', 'chuyen_mucs.id', 'client_settings.id_chuyen_muc')
            ->select('chuyen_mucs.*', 'client_settings.*')
            ->orderBy('client_settings.page', 'asc')
            ->get();
        $listGame = \App\Models\ChuyenMuc::leftJoin('danh_mucs', 'danh_mucs.id_chuyen_muc', 'chuyen_mucs.id')
            ->where('chuyen_mucs.loai', 'game')
            ->orderBy('chuyen_mucs.id')
            ->select('danh_mucs.mo_ta', 'chuyen_mucs.*')
            ->distinct()
            ->get();
        $cau_hoi = \App\Models\CauHoi::get();
        $count_cau_hoi = count($cau_hoi);
        $thongTin = \App\Models\ThongTin::get();
    @endphp
    @if (count($thongTin) > 0)
        <div class="popup">
            <div class="content">
                <div class="close"><i class="uil uil-minus"></i></div>
                <h3>{{ $thongTin[0]->title ? $thongTin[0]->title : 'Cập Nhật Các Thông Tin Liên Quan Về Mod Và TikTok' }}
                </h3>
                <p>{{ $thongTin[0]->noi_dung ? $thongTin[0]->noi_dung : '' }}</p>
                @php
                    $moTa = explode(',', $thongTin[0]->mo_ta);
                @endphp
                @foreach ($moTa as $value)
                    @php
                        $_moTa = explode('|', $value);
                    @endphp
                    @if (count($_moTa))
                        <div style="display: flex; align-items: center;">
                            <img alt="" src="https://cdn.discordapp.com/emojis/929897997465174016.gif"
                                style="height: 28px; width: 30px;">
                            <h4>{{ $_moTa[0] ? $_moTa[0] : '' }}</h4>
                            <a href="{{ $_moTa[1] ? $_moTa[1] : '' }}" style="color: blue;">Truy Cập</a>
                        </div>
                    @endif
                @endforeach
                <ul class="icons">
                    <a href="{{ $thongTin[0]->facebook ? $thongTin[0]->facebook : '' }}"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="{{ $thongTin[0]->zalo ? $thongTin[0]->zalo : '' }}">
                        <svg id="changeColor" fill="#DC7633" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="200" zoomAndPan="magnify"
                            viewBox="0 0 375 374.9999" height="200" preserveAspectRatio="xMidYMid meet" version="1.0">
                            <defs></defs>
                            <g></g>
                            <g id="inner-icon" transform="translate(85, 75)"> <svg role="img" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" id="IconChangeColor" height="218" width="218">
                                    <title>Zalo</title>
                                    <path
                                        d="M12.49 10.2722v-.4496h1.3467v6.3218h-.7704a.576.576 0 01-.5763-.5729l-.0006.0005a3.273 3.273 0 01-1.9372.6321c-1.8138 0-3.2844-1.4697-3.2844-3.2823 0-1.8125 1.4706-3.2822 3.2844-3.2822a3.273 3.273 0 011.9372.6321l.0006.0005zM6.9188 7.7896v.205c0 .3823-.051.6944-.2995 1.0605l-.03.0343c-.0542.0615-.1815.206-.2421.2843L2.024 14.8h4.8948v.7682a.5764.5764 0 01-.5767.5761H0v-.3622c0-.4436.1102-.6414.2495-.8476L4.8582 9.23H.1922V7.7896h6.7266zm8.5513 8.3548a.4805.4805 0 01-.4803-.4798v-7.875h1.4416v8.3548H15.47zM20.6934 9.6C22.52 9.6 24 11.0807 24 12.9044c0 1.8252-1.4801 3.306-3.3066 3.306-1.8264 0-3.3066-1.4808-3.3066-3.306 0-1.8237 1.4802-3.3044 3.3066-3.3044zm-10.1412 5.253c1.0675 0 1.9324-.8645 1.9324-1.9312 0-1.065-.865-1.9295-1.9324-1.9295s-1.9324.8644-1.9324 1.9295c0 1.0667.865 1.9312 1.9324 1.9312zm10.1412-.0033c1.0737 0 1.945-.8707 1.945-1.9453 0-1.073-.8713-1.9436-1.945-1.9436-1.0753 0-1.945.8706-1.945 1.9436 0 1.0746.8697 1.9453 1.945 1.9453z"
                                        id="mainIconPathAttribute" fill="blue"></path>
                                </svg> </g>
                        </svg>
                    </a>
                    <a href="{{ $thongTin[0]->messenger ? $thongTin[0]->messenger : '' }}"><i
                            class="fa-brands fa-facebook-messenger"></i></a>
                    <a href="{{ $thongTin[0]->telegram ? $thongTin[0]->telegram : '' }}"><i
                            class="fab fa-telegram-plane"></i></a>
                </ul>
                <p>Số Điện Thoại Liên Hệ</p>
                <div class="field">
                    <i class="url-icon uil uil-link"></i>
                    <input class="valueCopy" type="text" readonly
                        value="{{ $thongTin[0]->sdt ? $thongTin[0]->sdt : '' }}">
                    <button class="copyButton">Copy</button>
                </div>
                {{-- <ul class="icons" style="width: 20%;text-align: center; margin-bottom: 5px;">
                    <div class="close"><i class="uil uil-minus"></i></div>
                    <div class="remove"><i class="uil uil-times"></i></div>
                </ul> --}}
            </div>
        </div>
    @endif
    <div class="coinbg">
        <!--========== HOME ==========-->
        @foreach ($listBanner as $value)
            @if ($value->page == 1)
                <section class="home" id="taiKhoan">
                    <div class="home__container bd-container bd-grid">
                        <div class="home__img">
                            <img src="{{ $value->hinh_anh }}" alt="">
                        </div>

                        <div class="home__data">
                            <h1 class="home__title">{{ $value->title }}</h1>
                            <p class="home__description">{{ $value->description }}</p>
                            <a href="/pay/{{ $value->slug_chuyen_muc }}" class="button-62" role="button">Xem Ngay</a>
                        </div>
                    </div>
                </section>
            @elseif ($value->page == 2)
                <!--========== SHARE ==========-->
                <section class="share section bd-container" id="coinTikTok">
                    <div class="share__container bd-grid">
                        <div class="share__img">
                            <img src="{{ $value->hinh_anh }}" alt="">
                        </div>
                        <div class="share__data">
                            <h2 class="section-title-center">{{ $value->title }}</h2>
                            <p class="share__description">{{ $value->description }}</p>
                            <a href="/pay/{{ $value->slug_chuyen_muc }}" class="button-62" role="button">Xem Ngay</a>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    </div>
    <!--========== ACCESSORIES ==========-->
    <section class="accessory section bd-container" id="sanPham" loading="lazy">
        <h2 class="section-title">Danh Sách<br>Các Game Đang Bán</h2>
        <div class="accessory__container bd-grid">
            @foreach ($listGame as $value)
                @if ($value->status)
                    <div class="accessory__content">
                        <img src="{{ $value->logo }}" alt="" class="accessory__img">
                        <h3 class="accessory__title">{{ $value->ten_chuyen_muc }}</h3>
                        <span class="accessory__category">{{ $value->mo_ta }}</span>
                        <button class="button-85" role="button"
                            onclick="window.location.href='/pay/{{ $value->slug_chuyen_muc }}'">
                            Xem Ngay
                        </button>
                        {{-- <span class="accessory__preci">Xem Ngay</span> --}}
                        {{-- <a href="#" class="button accessory__button"><i class='bx bx-heart'></i></a> --}}
                    </div>
                @endif
            @endforeach
        </div>
    </section>
    @if ($count_cau_hoi != 0)
        <section class="accessory section bd-container accordion" id="accordion">
            <h2 class="section-title">Câu Hỏi Thường Gặp</h2>
            <div class="accessory__container" style="width: 90%;margin: 0 auto;">
                @foreach ($cau_hoi as $value)
                    <div class="accordion-content">
                        <header>
                            <span class="title">{{ $value->cau_hoi }}?</span>
                            <i class="fa-solid fa-plus"></i>
                        </header>
                        <p class="description">
                            {{ $value->tra_loi }}
                        </p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Tải Về  --}}
    <section class="home" loading="lazy">
        <div class="home__container bd-container bd-grid">
            <div class="home__data">
                <span class="section-subtitle app__initial" style="color: rgb(72, 0, 255);"><b>TikTok</b></span>
                <h2 class="section-title app__initial">Ứng Dụng Đã Sẵn Sàng</h2>
                <p class="app__description">TikTok Nay Đã Có Sẵn Trên AppStore Và Google Play <br> Hãy tải ứng dụng TikTok
                    ngay để khám phá thế giới giải trí đa dạng và thú vị</p>
                <div class="app__stores" style="display: flex;justify-content: center;">
                    <a href="https://www.tiktok.com/download-link/af/id1235601864"><img src="/app1.png" alt=""
                            class="app__store"></a>
                    <a href="https://www.tiktok.com/download-link/af/com.ss.android.ugc.trill"><img src="/app2.png"
                            alt="" class="app__store ml-1"></a>
                </div>
            </div>
            <div class="home__img">
                <img src="/tiktok.svg">
            </div>

        </div>
    </section>
@endsection
@section('js')
    <script>
        const viewBtn = document.querySelector(".view-modal"),
            popup = document.querySelector(".popup"),
            close = popup.querySelector(".close"),
            // remove = popup.querySelector(".remove"),
            field = popup.querySelector(".field"),
            input = field.querySelector(".valueCopy"),
            copy = field.querySelector(".copyButton");
        // if (!localStorage.getItem('hideModal')) {
        //     popup.classList.toggle("show");
        //     remove.onclick = () => {
        //         if (confirm('Bạn Có Chắc Chắn Muốn Ẩn Thông Báo Này Mãi Mãi?')) {
        //             popup.classList.toggle("show");
        //             localStorage.setItem('hideModal', true);
        //         }
        //     }
        // }
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                popup.classList.toggle("show");
            }, 1500);
        });
        close.onclick = () => {
            popup.classList.toggle("show");
        }

        copy.onclick = () => {
            input.select(); //select input value
            if (document.execCommand("copy")) { //if the selected text copy
                field.classList.add("active");
                copy.innerText = "Xong";
                setTimeout(() => {
                    window.getSelection().removeAllRanges(); //remove selection from document
                    field.classList.remove("active");
                    copy.innerText = "Copy";
                }, 5000);
            }
        }
    </script>
    <script>
        const accordionContent = document.querySelectorAll(".accordion-content");
        accordionContent.forEach((item, index) => {
            let header = item.querySelector("header");
            header.addEventListener("click", () => {
                item.classList.toggle("open");

                let description = item.querySelector(".description");
                if (item.classList.contains("open")) {
                    description.style.height =
                        `${description.scrollHeight}px`; //scrollHeight property returns the height of an element including padding , but excluding borders, scrollbar or margin
                    item.querySelector("i").classList.replace("fa-plus", "fa-minus");
                } else {
                    description.style.height = "0px";
                    item.querySelector("i").classList.replace("fa-minus", "fa-plus");
                }
                removeOpen(
                    index); //calling the funtion and also passing the index number of the clicked header
            })
        })

        function removeOpen(index1) {
            accordionContent.forEach((item2, index2) => {
                if (index1 != index2) {
                    item2.classList.remove("open");

                    let des = item2.querySelector(".description");
                    des.style.height = "0px";
                    item2.querySelector("i").classList.replace("fa-minus", "fa-plus");
                }
            })
        }
    </script>
@endsection
