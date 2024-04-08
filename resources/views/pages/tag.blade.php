@extends('layout')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Từ khóa: {{ $slugTK }}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12">
        <div class="album py-5 bg-body-tertiary">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($truyenTim as $truyen)
                    <div class="col">
                        <div class="card shadow-sm">
                            <a href="{{ route('xemtruyen',['slug'=>$truyen->slug]) }}">
                                <span class="text-overlay bg-red rounded">Truyện mới</span>
                            <img style="border: 2px solid black; width: 100%;height: 280px;" class="card-img-top" src="{{ $truyen->image }}"
                                alt="">
                            </a>
                            <div class="card-body">
                                <div class="card-title">
                                    <span style="font-family: 'Patrick Hand', cursive; font-size: 20px">{{ $truyen->name }}</span>
                                </div>
                                <p class="card-text summary" style="text-align: justify">{{ $truyen->description }}.</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-danger" href="{{ route('xemtruyen',['slug'=>$truyen->slug]) }}"  class="btn btn-sm btn-outline-secondary">Đọc
                                            ngay</a>
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
