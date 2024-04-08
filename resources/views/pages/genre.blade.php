@extends('layout')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $theloaiName }}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
        <div class="album py-5 ">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($truyenTheoTheLoai as $key => $truyen)
                    <div class="col">
                        <div class="card shadow-sm">
                            <a href="{{ route('xemtruyen',['slug'=>$truyen->slug]) }}">
                            <img style="border: 2px solid black; width: 100%;height: 290px;" class="card-img-top" src="{{ $truyen->image }}"
                                alt="">
                            </a>
                            <div class="card-body">
                                <h3>{{ $truyen->name }}</h3>
                                <p class="card-text summary" style="text-align: justify">{{ $truyen->description }}.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        @if ($chuongDauMoiTruyen[$key] == NULL)
                                            <button class="btn btn-danger" disabled>Đọc ngay</button>
                                        @else
                                        <a class="btn btn-danger" href="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chuongDauMoiTruyen[$key]->slug]) }}"  class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</a>
                                        @endif

                                        <a class="btn btn-sm btn-outline-secondary"><i
                                                class="fa-solid fa-eye"></i> 3521</a>
                                    </div>
                                    <small class="text-body-secondary">9 mins ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
