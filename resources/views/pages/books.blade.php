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

        $(document).on('click', '.watch_book', function (){
            var book_id = $(this).attr('id');
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ route('xem-sach-nhanh') }}',
                method: 'post',
                dataType: 'json',
                data: {book_id:book_id, _token:_token},
                success: (data)=>{
                    $('#tieudesach').html(data.tieudesach);
                    $('#noidungsach').html(data.noidungsach);
                }

            });
        });
    </script>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Sách</li>
    </ol>
</nav>
    <div class="row mt-3">
        <h3>SÁCH MỚI CẬP NHẬT</h3>
        <div class="album py-5">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($sach as $keyTruyen => $truyen)
                        <div class="col">
                            <div class="card shadow-sm">
                                <span class="text-overlay bg-red rounded">Sách mới</span>

                                    <img style="border: 2px solid black; width: 100%;height: 280px;" class="card-img-top"
                                        src="{{ $truyen->image }}" alt="">

                                <div class="card-body">
                                    <div class="card-title">
                                        <span
                                            style="font-family: 'Patrick Hand', cursive; font-size: 23px">{{ $truyen->name }}</span>
                                    </div>
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
                                            <form action="">
                                            @csrf
                                            <button type="button" id="{{ $truyen->id }}" class="btn btn-primary watch_book" data-toggle="modal"
                                                data-target="#staticBackdrop">
                                                Đọc ngay
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdrop" data-backdrop="static"
                                                data-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content" >
                                                        <div class="modal-header text-center">
                                                            <h5 class="modal-title w-100" id="staticBackdropLabel"  style="text-align: center">
                                                                <div id="tieudesach" style="font-size: 30px; font-weight: bold;font-family: 'Patrick Hand', cursive;text-align: center; color: red !important"></div>
                                                            </h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="noidungsach" style="color: black !important">

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button disabled class="btn btn btn-outline-secondary"
                                                style="text-align: center; opacity: 1.0;"><i class="fa-solid fa-eye"
                                                    style="text-align: center"></i> 3521
                                                </button>
                                            </form>
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

    {{-- <div class="row mt-3">
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
    </div> --}}
@endsection
