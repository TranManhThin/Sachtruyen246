@extends('layout')
@section('js')
    <script>
        $('.thich-truyen').click(function() {
            const id = $('.likelist_id').val();
            const name = $('.likelist_name').val();
            const url = $('.likelist_url').val();
            const image = $('.card-img-top').attr('src');
            const author = $('.likelist_author').val();
            const genre = $('.likelist_genre').val();
            const category = $('.likelist_category').val();
            const item = {
                'id': id,
                'name': name,
                'url': url,
                'image': image,
                'author': author,
                'genre': genre,
                'category': category
            }
            if (localStorage.getItem('like_list') == null) {
                localStorage.setItem('like_list', '[]');
            }
            var old_data = JSON.parse(localStorage.getItem('like_list'));
            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            });
            if (matches.length) {
                for (let index = 0; index < old_data.length; index++) {
                    if (id == old_data[index].id) {
                        old_data.splice(index, 1);
                        itemNeedRemove = index;
                        // $('#itemRemove'+index+'').remove();
                    }
                }

                $('#heart').css('color', 'white');
                location.reload(true);
            } else {
                if (old_data.length < 6) {
                    $('#heart').css('color', 'red');
                    old_data.push(item);
                    localStorage.setItem('like_list', JSON.stringify(old_data));
                    alert('Đã lưu vào danh sách yêu thích');
                    $('.yeu_thich').append(`<div class="row rounded">

<div class="col-md-6">
    <a href="` + url + `">
        <img style="width: 125px;height: 160px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);" class="rounded"
            src="` + image + `" alt="">
        <span class="text-overlay1 bg-red rounded">Truyện mới</span>

    </a>
</div>
<div class="col-md-6">
    <p style="font-size: 15px; height: 160px; overflow: hidden; text-overflow: ellipsis">
        ` + name + ` <br>` + author + ` <br>
        9 phút trước <br> <i class="fa fw fa-eye"></i> 303 <br> <span
            class="text-dark bg-primary rounded">` + genre + `</span> <br>
        <span class="text-dark bg-dark rounded"
            style="color: white !important">` + category + `</span>
    </p>
</div>
</div>
`);
                } else {
                    alert('Danh sách yêu thích đã đầy!');
                }

            }
            localStorage.setItem('like_list', JSON.stringify(old_data));
        });

        var old_data = JSON.parse(localStorage.getItem('like_list'));
        var idHienTai = $('.likelist_id').val();
        for (let i = 0; i < old_data.length; i++) {
            if (idHienTai == old_data[i].id) {
                $('#heart').css('color', 'red');
            }

            $('.yeu_thich').append(`<div id="itemRemove` + i + `" class="row rounded">

<div class="col-md-6">
    <a href="` + old_data[i].url + `">
        <img style="width: 125px;height: 160px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);" class="rounded"
            src="` + old_data[i].image + `" alt="">
        <span class="text-overlay1 bg-red rounded">Truyện mới</span>

    </a>
</div>
<div class="col-md-6">
    <p style="font-size: 15px; height: 160px; overflow: hidden; text-overflow: ellipsis">
        ` + old_data[i].name + ` <br>` + old_data[i].author + ` <br>
        9 phút trước <br> <i class="fa fw fa-eye"></i> 303 <br> <span
            class="text-dark bg-primary rounded">` + old_data[i].genre + `</span> <br>
        <span class="text-dark bg-dark rounded"
            style="color: white !important">` + old_data[i].category + `</span>
    </p>
</div>
</div>
`);
        }
    </script>
@endsection
@section('css')
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
                color: red;
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
            80% {

            }

            100% {
                opacity: 1;
                color: rgb(255, 183, 0);
            }
        }

        .blinking-text {
            animation: blink 1s linear infinite;
            font-weight: bold;
            font-family: 'Dancing Script', cursive;
            margin-bottom: 15px;
        }

        .text-overlay1 {
            position: absolute;
            top: 1px;
            /* Điều chỉnh vị trí theo yêu cầu */
            left: 10px;
            /* Điều chỉnh vị trí theo yêu cầu */
            color: white;
            /* Màu văn bản */
            background-color: red;
            border-radius: 5px;
            font-size: 12px;
            /* Kích thước font */
            font-weight: bold;
            /* Độ đậm của font */
            /* Các thuộc tính khác tùy thuộc vào yêu cầu của bạn */
        }

        .tagcloud05 ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tagcloud05 ul li {
            display: inline-block;
            margin: 0 0 .3em 1em;
            padding: 0;
        }

        .tagcloud05 ul li a {
            position: relative;
            display: inline-block;
            height: 30px;
            line-height: 30px;
            padding: 0 1em;
            background-color: #0575c0;
            border-radius: 0 3px 3px 0;
            color: #fff;
            font-size: 13px;
            text-decoration: none;
            -webkit-transition: .2s;
            transition: .2s;
        }

        .tagcloud05 ul li a::before {
            position: absolute;
            top: 0;
            left: -15px;
            content: '';
            width: 0;
            height: 0;
            border-color: transparent #3498db transparent transparent;
            border-style: solid;
            border-width: 15px 15px 15px 0;
            -webkit-transition: .2s;
            transition: .2s;
        }

        .tagcloud05 ul li a::after {
            position: absolute;
            top: 50%;
            left: 0;
            z-index: 2;
            display: block;
            content: '';
            width: 6px;
            height: 6px;
            margin-top: -3px;
            background-color: #fff;
            border-radius: 100%;
        }

        .tagcloud05 ul li span {
            display: block;
            max-width: 100px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .tagcloud05 ul li a:hover {
            background-color: #555;
            color: #fff;
        }

        .tagcloud05 ul li a:hover::before {
            border-right-color: #555;
        }
    </style>
@endsection
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('theloai', ['slugTL' => $truyen->genre->slug]) }}">{{ $truyen->genre->name }}</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('danhmuc', ['slugDM' => $truyen->category->slug]) }}">{{ $truyen->category->name }}</a>
            </li>
            <li class="breadcrumb-item active">{{ $truyen->name }}</li>

        </ol>
    </nav>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <h3>{{ $truyen->name }}</h3>
                <div class="col-md-3">
                    <img style="width: 210px;height: 240px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);" class="card-img-top"
                        src="{{ $truyen->image }}" alt="">
                </div>
                <div class="col-md-6">
                    <input type="hidden" value="{{ $truyen->id }}" class="likelist_id">
                    <input type="hidden" value="{{ $truyen->name }}" class="likelist_name">
                    <input type="hidden" value="{{ URL::current() }}" class="likelist_url">
                    <input type="hidden" value="{{ $truyen->category->name }}" class="likelist_category">
                    <input type="hidden" value="{{ $truyen->genre->name }}" class="likelist_genre">
                    <input type="hidden" value="{{ $truyen->author }}" class="likelist_author">

                    <ul class="infoStory" style="list-style: none">
                        <li>Tác giả: {{ $truyen->author }}</li>
                        <li>Danh mục: <a href="{{ route('danhmuc', ['slugDM' => $truyen->category->slug]) }}"
                                style="text-decoration-line: none"> <span
                                    class="text-light bg-dark rounded">{{ $truyen->category->name }}</span></a>
                        </li>
                        <li>Thể loại: <a href="{{ route('theloai', ['slugTL' => $truyen->genre->slug]) }}"
                                style="text-decoration-line: none"> <span
                                    class="text-dark bg-primary rounded">{{ $truyen->genre->name }}</span></a>
                        </li>
                        <li>Số chương: {{ count($chapter) }}</li>
                        <li>Số lượt xem: 5000</li>
                        <div class="g-ytsubscribe" data-channelid="UCTKY9iSrSNctixAyP2AZ7kQ" data-layout="default" data-count="default"></div>
                        <li><a href="#mucluc">Xem mục lục</a></li>
                        @if (empty($chapterDau->slug))
                            <li>
                                <button disabled type="button" class="btn btn-danger">Đọc truyện</button>
                                <button class="btn btn-warning thich-truyen"><i class="fa fw fa-heart" id="heart"
                                        aria-hidden="true"></i> Yêu thích</button>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('xemchuong', ['slug' => $truyen->slug, 'slugChapter' => $chapterDau->slug]) }}"
                                    class="btn btn-danger">Đọc ngay</a>
                                <button class="btn btn-warning thich-truyen"><i class="fa fw fa-heart" id="heart"
                                        aria-hidden="true"></i> Yêu thích</button>
                            </li>
                        @endif
                        <li>
                            @if ($chapterCuoi !== null)
                                <a href="{{ route('xemchuong', ['slug' => $truyen->slug, 'slugChapter' => $chapterCuoi->slug]) }}"
                                    class="btn btn-primary mt-2">Đọc chương mới nhất</a>
                            @else
                                <button class="btn btn-primary mt-2" disabled>Đọc chương mới nhất</button>
                            @endif
                        </li>
                    </ul>
                </div>
                <hr>
                <div class="col-md-12">
                    <p style="text-align: justify">{{ $truyen->description }}</p>
                </div>
                <hr>
                <h4>Từ khóa tìm kiếm: </h4>
                @php
                    $tukhoa = explode(',', $truyen->keyword);
                @endphp
                <div class="tagcloud05">
                    <ul>
                        @foreach ($tukhoa as $key)
                            <li><a
                                    href="{{ route('tukhoa', ['slugTK' => Str::slug($key)]) }}"><span>{{ $key }}</span></a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <hr>
                <h4>Mục lục</h4>
                @php
                    $countML = $chapter->count();
                @endphp
                <div class="noidungchuong">
                    @if ($countML == 0)
                        <p>Đang cập nhật</p>
                    @else
                        <ul class="mucluc" id="mucluc" style="list-style: none;">
                            @foreach ($chapter as $chuong)
                                <li><a
                                        href="{{ route('xemchuong', ['slug' => $truyen->slug, 'slugChapter' => $chuong->slug]) }}">{{ $chuong->name }}</a>
                                </li>
                            @endforeach


                        </ul>
                    @endif
                </div>
                <hr>

                <div class="fb-share-button" data-href="{{ URL::current() }}" data-layout="button_count" data-size="large">
                    <a target="_blank"
                        href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F127.0.0.1%3A8000%2Fxem-truyen%2Fong-gia-va-bien-ca%2Fchapter-1-ong-gia-ra-khoi&amp;src=sdkpreparse"
                        class="fb-xfbml-parse-ignore">Chia sẻ</a>
                </div>
                <div class="fb-comments" data-href="{{ URL::current() }}" data-width="100%" data-numposts="50"></div>

                <hr>
                <h3>Truyện cùng thể loại</h3>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($truyenCungDanhMuc as $cungdanhmuc)
                        <div class="col">
                            <div class="card shadow-sm">
                                <a href="{{ route('xemtruyen', ['slug' => $cungdanhmuc->slug]) }}">
                                    <img style="border: 2px solid black; width: 100%;height: 280px;" class="card-img-top"
                                        src="{{ $cungdanhmuc->image }}" alt="">
                                </a>
                                <div class="card-body">
                                    <p class="card-text summary" style="text-align: justify">
                                        {{ $cungdanhmuc->description }}</p>
                                    {{-- <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                    ngay</button>
                                <a class="btn btn-sm btn-outline-secondary"><i
                                        class="fa-solid fa-eye"></i> 3521</a>
                            </div>
                            <small class="text-body-secondary float-right">9 mins ago</small>
                        </div> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <h4 class="blinking-text">Mới cập nhật</h4>
            @foreach ($truyenCungDanhMuc as $cungdanhmuc)
                <div class="row rounded">

                    <div class="col-md-6">
                        <a href="{{ route('xemtruyen', ['slug' => $cungdanhmuc->slug]) }}">
                            <img style="width: 125px;height: 160px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);" class="rounded"
                                src="{{ $cungdanhmuc->image }}" alt="">
                            <span class="text-overlay1 bg-red rounded">Truyện mới</span>

                        </a>
                    </div>
                    <div class="col-md-6">
                        <p style="font-size: 15px; height: 160px; overflow: hidden; text-overflow: ellipsis">
                            {{ $cungdanhmuc->name }} <br>{{ $cungdanhmuc->author }} <br>
                            9 phút trước <br> <i class="fa fw fa-eye"></i> 303 <br> <span
                                class="text-dark bg-primary rounded">{{ $cungdanhmuc->genre->name }}</span> <br>
                            <span class="text-dark bg-dark rounded"
                                style="color: white !important">{{ $cungdanhmuc->category->name }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
            <hr>
            <h4 class="blinking-text">Truyện nổi bật</h4>
            @foreach ($truyenNoiBat as $cungdanhmuc)
                <div class="row rounded">

                    <div class="col-md-6">
                        <a href="{{ route('xemtruyen', ['slug' => $cungdanhmuc->slug]) }}">
                            <img style="width: 125px;height: 160px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);"
                                class="rounded" src="{{ $cungdanhmuc->image }}" alt="">
                            <span class="text-overlay1 bg-red rounded">Truyện mới</span>

                        </a>
                    </div>
                    <div class="col-md-6">
                        <p style="font-size: 15px; height: 160px; overflow: hidden; text-overflow: ellipsis">
                            {{ $cungdanhmuc->name }} <br>{{ $cungdanhmuc->author }} <br>
                            9 phút trước <br> <i class="fa fw fa-eye"></i> 303 <br> <span
                                class="text-dark bg-primary rounded">{{ $cungdanhmuc->genre->name }}</span> <br>
                            <span class="text-dark bg-dark rounded"
                                style="color: white !important">{{ $cungdanhmuc->category->name }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
            <hr>
            <h4 class="blinking-text">Truyện xem nhiều</h4>
            @foreach ($truyenXemNhieu as $cungdanhmuc)
                <div class="row rounded">

                    <div class="col-md-6">
                        <a href="{{ route('xemtruyen', ['slug' => $cungdanhmuc->slug]) }}">
                            <img style="width: 125px;height: 160px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);"
                                class="rounded" src="{{ $cungdanhmuc->image }}" alt="">
                            <span class="text-overlay1 bg-red rounded">Truyện mới</span>

                        </a>
                    </div>
                    <div class="col-md-6">
                        <p style="font-size: 15px; height: 160px; overflow: hidden; text-overflow: ellipsis">
                            {{ $cungdanhmuc->name }} <br>{{ $cungdanhmuc->author }} <br>
                            9 phút trước <br> <i class="fa fw fa-eye"></i> 303 <br> <span
                                class="text-dark bg-primary rounded">{{ $cungdanhmuc->genre->name }}</span> <br>
                            <span class="text-dark bg-dark rounded"
                                style="color: white !important">{{ $cungdanhmuc->category->name }}</span>
                        </p>
                    </div>
                </div>
            @endforeach
            <hr>
            <h3 class="blinking-text">Truyện yêu thích</h3>

            <div class="yeu_thich">

            </div>

        </div>
    </div>

@endsection
