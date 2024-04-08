<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sách truyện</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('admin/vendor/bootstrap5/img/mdb-favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <style>
        .switch_color_white {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
        }

        .switch_color {
            background-color: #2e2e2e;
            color: whitesmoke;
        }

        .switch_color_1 {
            background-color: white;
            color: black;
        }

        .switch_color_2 {
            background-color: #e8b582;
            color: whitesmoke;
        }

        @keyframes blinking {
            0% {
                opacity: 1;
                color: rgb(247, 13, 255);
            }

            20% {
                opacity: 1;
                color: rgb(234, 255, 0);
            }

            40% {
                color: rgb(0, 255, 0);
            }

            60% {
                color: rgb(7, 247, 255);
            }

            80% {}

            100% {
                opacity: 1;
                color: rgb(255, 183, 0);
            }
        }


        .text-overlay {
            position: absolute;
            animation: blinking 1s linear infinite;
            top: 5px;
            /* Điều chỉnh vị trí theo yêu cầu */
            left: 5px;
            /* Điều chỉnh vị trí theo yêu cầu */
            color: white;
            /* Màu văn bản */
            background-color: red;
            border-radius: 5px;
            font-size: 18px;
            /* Kích thước font */
            font-weight: bold;
            /* Độ đậm của font */
            /* Các thuộc tính khác tùy thuộc vào yêu cầu của bạn */
        }

        .summary {
            width: 100%;
            text-align: justify;
            height: 100px;
            /* Độ rộng tóm tắt */
            white-space: normal;
            /* Ngăn văn bản ngắn xuống hàng */
            overflow: hidden;
            /* Ẩn phần dư thừa nếu vượt quá độ rộng */
            text-overflow: ellipsis;
            /* Hiển thị dấu chấm ba khi văn bản bị cắt bớt */
        }

        .dropdown.search {
            margin-top: 35px;


        }

        ul.dropdown-menu li {
            width: 318px;

        }

        ul.dropdown-menu li a {
            padding: 10px 15px;
            color: #0a009c;
            font-size: 18px;
            width: 218px;
        }

        @keyframes rainbow-border {
            0% {
                border-image: linear-gradient(to right, violet, indigo, blue, green, yellow, orange, red);
            }

            100% {
                border-image: linear-gradient(to right, violet, indigo, blue, green, yellow, orange, red);
            }
        }
    </style>
    @yield('css')
</head>

<body class="">

    <div class="container">
        <span
            style="
        font-size: 35px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        color: #49fb09;
        font-weight: bold;
        font-family: 'Patrick Hand', cursive;
        letter-spacing: 1px;">Sach</span><span
            style="
            font-size: 35px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: #f9671e;
            font-weight: bold;
            font-family: 'Patrick Hand', cursive;
            letter-spacing: 1px;">truyen</span><span
            style="
            font-size: 35px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: #4e99db;
            font-weight: bold;
            font-family: 'Patrick Hand', cursive;
            letter-spacing: 1px;">246</span>
        @if (Request::session()->has('login_session'))

        <div class="dropdown float-right mt-2">
            {{-- <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown button
            </button> --}}
            <span class="">{{ Request::session()->get('user_fullname') }}</span>
            <a role="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuButton">
                <img src="{{ asset('admin/img/user-icon-1024x1024-dtzturco.png') }}" alt="" class="img-profile rounded-circle" width="40px" height="40px">
            </a>

            <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">

              <a class="dropdown-item" href="#">Yêu thích</a>
              <a class="dropdown-item" href="#">VIP</a>
              <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
          </div>
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"> Xác nhận đăng xuất tài khoản.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="{{ route('dangXuat') }}">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>

        @else
        <div class="float-right mt-2">
            <a href="{{ route('dangKy') }}" class="btn btn-outline-primary">Đăng ký</a>
            <a href="{{ route('dangNhap') }}" class="btn btn-primary">Đăng nhập</a>
        </div>
        @endif

        <nav class="navbar navbar-expand-lg  rounded" style="font-size: 20px; background-color: #f1d9c2">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto" style="font-family: 'Segoe UI', Arial, sans-serif; ">
                    <li class="nav-item active">
                        <a style="color: #ffffff" class="nav-link" href="{{ route('trangchu') }}"><span style="font-weight: bold; ">Trang
                                chủ</span></a>
                    </li>
                    <li class="nav-item">
                        <a style="color: #ffffff" class="nav-link" href="{{ route('home') }}"><i class="fa-solid fa-book-quran"></i> Truyện</a>
                    </li>
                    <li class="nav-item">
                        <a style="color: #ffffff" class="nav-link" href="{{ route('sach') }}"><i class="fa-solid fa-book-bookmark"></i> Sách</a>
                    </li>
                    <li class="nav-item">
                        <a style="color: #ffffff" class="nav-link" href="{{ route('alphabet') }}"><i class="fa-solid fa-font"></i>lphabet</a>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Danh mục truyện
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($danhmucTruyen as $value)
                                <a class="dropdown-item"
                                    href="{{ route('danhmuc', ['slugDM' => $value->slug]) }}">{{ $value->name }}</a>
                            @endforeach

                        </div>
                    </li> --}}

                    <li class="nav-item dropdown">
                        <a style="color: #ffffff" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-tag"></i> Thể loại
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($theLoai as $value)
                            <span> <a class="dropdown-item"
                                href="{{ route('theloai', ['slugTL' => $value->slug]) }}"><i class="fa-solid fa-tag"></i>  {{ $value->name }}</a></span>
                            @endforeach
                        </div>
                    </li>

                </ul>
                <div class="dropdown select mr-2">
                    <select name="" id="switch_color" class="custom-select" style="text-align: justify">
                        <option value="trang">Trắng</option>
                        <option value="xam">Xám</option>
                        <option value="xam-den">Cam nhạt</option>

                    </select>
                </div>
                <div id="search_ajax" class="dropdown search"></div>
                <form autocomplete="off" action="{{ route('timKiem') }}" class="form-inline my-2 my-lg-0"
                    method="POST">
                    @csrf
                    <input name="keyword" id="keyword" class="form-control mr-sm-2" type="search"
                        placeholder="Tác giả, truyện,..." aria-label="Search">

                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>

                </form>

            </div>
        </nav>
        <hr>


        {{-- Slider --}}
        @yield('slider')
        {{-- content --}}
        @yield('content')
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top footer">
            <p class="col-md-4 mb-0">&copy; Company, Inc</p>

            <a href="/"
                class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap" />
                </svg>
            </a>

            <ul class="nav col-md-4 justify-content-end" class="color: white">
                <li class="nav-item"><a href="#" class="nav-link px-2 footer">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 footer">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 footer">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 footer">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 footer">About</a></li>
            </ul>


        </footer>
    </div>


    </div>



    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v19.0"
        nonce="30nLQ5mv"></script>
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://apis.google.com/js/platform.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script>
        $('#keyword').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('timKiemAjax') }}",
                    method: 'post',
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                        console.log("Success");
                    }
                })
            } else {
                $('#search_ajax').fadeOut();
            }
        });

        $(document).on('click', '.li_search_ajax', function() {

            $('#keyword').val($(this).text());
            $('#search_ajax').fadeOut();
        })
    </script>
    <script>
        $(document).ready(function() {


            if (localStorage.getItem('switch_color') !== null) {
                const data = localStorage.getItem('switch_color');
                const color = JSON.parse(data);

                $(document.body).addClass(color.class_1);
                $('.album').addClass(color.class_1);
                $('.footer').addClass(color.class_1);
                $('.card-body').addClass(color.class_1);
                $('.noidungchuong > ul > li > a').addClass(color.class_1);
                $('select option[value="' + color.value + '"]').attr('selected', 'selected');

            }
            $('#switch_color').change(function() {
                var color = $(this).val();
                var switchColor = '';
                var classes = {
                    'class_1': switchColor,
                    'value': color
                }
                // location.reload(true);

                if (color == 'xam') {
                    var bodyClass = $('body').attr('class');
                    if (bodyClass !== null || bodyClass !== '') {
                        $(document.body).toggleClass(bodyClass);
                        $('.album').toggleClass(bodyClass);
                        $('.footer').toggleClass(bodyClass);
                        $('.card-body').toggleClass(bodyClass);
                        $('.noidungchuong > ul > li > a').toggleClass(bodyClass);
                    }

                    $(document.body).toggleClass('switch_color');
                    $('.album').toggleClass('switch_color');
                    $('.footer').toggleClass('switch_color');
                    $('.card-body').toggleClass('switch_color');
                    $('.noidungchuong > ul > li > a').toggleClass('switch_color');
                    classes.class_1 = 'switch_color';
                    localStorage.setItem('switch_color', JSON.stringify(classes));

                } else if (color == 'trang') {
                    var bodyClass = $('body').attr('class');

                    $(document.body).toggleClass(bodyClass);
                    $('.album').toggleClass(bodyClass);
                    $('.footer').toggleClass(bodyClass);
                    $('.card-body').toggleClass(bodyClass);
                    $('.noidungchuong > ul > li > a').toggleClass(bodyClass);

                    $(document.body).toggleClass('switch_color_1');
                    $('.album').toggleClass('switch_color_1');
                    $('.footer').toggleClass('switch_color_1');
                    $('.card-body').toggleClass('switch_color_1');
                    $('.noidungchuong > ul > li > a').toggleClass('switch_color_1');
                    localStorage.removeItem('switch_color');

                } else if (color == 'xam-den') {
                    var bodyClass = $('body').attr('class');

                    if (bodyClass !== null || bodyClass == '') {
                        $(document.body).toggleClass(bodyClass);
                        $('.album').toggleClass(bodyClass);
                        $('.footer').toggleClass(bodyClass);
                        $('.card-body').toggleClass(bodyClass);
                        $('.noidungchuong > ul > li > a').toggleClass(bodyClass);
                    }

                    $(document.body).toggleClass('switch_color_2');
                    $('.album').toggleClass('switch_color_2');
                    $('.footer').toggleClass('switch_color_2');
                    $('.card-body').toggleClass('switch_color_2');
                    $('.noidungchuong > ul > li > a').toggleClass('switch_color_2');
                    classes.class_1 = 'switch_color_2';
                    localStorage.setItem('switch_color', JSON.stringify(classes));
                }


            });
        });
    </script>

    <script>
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 5,
                    nav: true,
                    loop: false
                }
            }
        })
    </script>



    @yield('js')
</body>

</html>
