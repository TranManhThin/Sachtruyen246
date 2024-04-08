@extends('layout')
{{-- @section('slider')
    @include('pages.slider')
@endsection --}}
@section('js')
    <script>
        $('.tabsDanhMuc').click(function() {
            const danhmucid = $(this).data('danhmucid');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('tabsDanhMuc') }}',
                method: 'POST',
                data: {
                    _token: _token,
                    danhmucid: danhmucid
                },
                success: (data) => {
                    $('#tabDanhMuc_' + danhmucid + '').html(data);
                    if (localStorage.getItem('switch_color') !== null) {
                        const data = localStorage.getItem('switch_color');
                        const color = JSON.parse(data);
                        $('.card-body').addClass(color.class_1);
                    }
                }

            })

        });
    </script>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="">
                @csrf
                <nav class="nav nav-tabs">

                    @foreach ($danhmucTruyen as $danhmuc)
                        <a style="text-decoration-line: none; text-decoration: none" href="#{{ $danhmuc->slug }}" class="nav-item nav-link tabsDanhMuc" data-toggle="tab"
                            data-danhmucid="{{ $danhmuc->id }}">
                            {{ $danhmuc->name }}
                        </a>
                    @endforeach


                </nav>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tab-content mt-3">
                @foreach ($danhmucTruyen as $danhmuc)
                    <div class="tab-pane container" id="{{ $danhmuc->slug }}">
                        {{-- <h3>Danh mục: {{ $danhmuc->name }}</h3> --}}
                        <div class="container">
                            <div id="tabDanhMuc_{{ $danhmuc->id }}" class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">

                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <hr>
    @php
        $key = [];
    @endphp
    <div class="row mt-3">
        <h3>HAY MỚI CẬP NHẬT</h3>
        <div class="album py-5">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($truyenMoi as $keyTruyen => $truyen)
                        <div class="col">
                            <div class="card shadow-sm">
                                <span class="text-overlay bg-red rounded">Truyện mới</span>
                                <a href="{{ route('xemtruyen', ['slug' => $truyen->slug]) }}">
                                    <img style="border: 2px solid black; width: 100%;height: 280px;" class="card-img-top"
                                        src="{{ $truyen->image }}" alt="">
                                </a>
                                <div class="card-body">
                                    <div class="card-title">
                                        <span
                                            style="font-family: 'Patrick Hand', cursive; font-size: 20px">{{ $truyen->name }}</span>
                                    </div>
                                    <p class="card-text summary">{{ $truyen->description }}.</p>
                                    <hr>
                                    <span class="text-light bg-dark rounded">{{ $truyen->category->name }}</span>
                                    <span class="text-light bg-dark rounded">{{ $truyen->genre->name }}</span>
                                    <hr>
                                    @php
                                        $tagsKey = explode(',', $truyen->keyword);
                                    @endphp
                                    @foreach ($tagsKey as $key => $value)
                                        <span class="text-light bg-primary rounded">{{ $value }}</span>
                                    @endforeach


                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            @php

                                            @endphp
                                            @if ($chuongDauMoiTruyen[$keyTruyen] == null)
                                                <button class="btn btn-danger" disabled>Đọc thêm</button>
                                            @else
                                                <a class="btn btn-danger"
                                                    href="{{ route('xemchuong', ['slug' => $truyen->slug, 'slugChapter' => $chuongDauMoiTruyen[$keyTruyen]->slug]) }}"
                                                    class="btn btn-sm btn-outline-secondary">Đọc
                                                    ngay</a>
                                            @endif

                                            <button disabled class="btn btn btn-outline-secondary"
                                                style="text-align: center; opacity: 1.0;"><i class="fa-solid fa-eye"
                                                    style="text-align: center"></i> 3521</button>
                                        </div>
                                        <small class="text-body-secondary">9 mins ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <a href="" class="btn btn-primary mt-3" style="float: right">Xem tất cả</a>
            </div>
        </div>
    </div>
    {{--
mmmm --}}
    <div class="row mt-3">
        <h3>SÁCH HAY XEM NHIỀU</h3>

        <div class="album py-5 ">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    <div class="col">
                        <div class="card shadow-sm">
                            <img style="border: 2px solid black; width: 210px;height: 235px;" class="card-img-top"
                                src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i> 3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i> 3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i> 3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i>
                                            3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <a href="" class="btn btn-primary mt-3" style="float: right">Xem tất cả</a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <h3>BLOGS</h3>

        <div class="album py-5 ">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i>
                                            3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i>
                                            3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i>
                                            3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{ asset('admin/img/rua-va-tho_2.jpg') }}" alt="">
                            <div class="card-body">
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content. This content is a little bit longer.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</button>
                                        <a class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i>
                                            3521</a>
                                    </div>
                                    <small class="text-body-secondary"></small>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <a href="" class="btn btn-primary mt-3" style="float: right">Xem tất cả</a>
            </div>
        </div>
    </div>
    <hr>

@endsection
