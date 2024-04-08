@extends('layout')
@section('slider')
    @include('pages.slider')
@endsection
@section('css')
    <style>
        .text-category {
            /* color: rgb(107, 77, 23); */
            font-size: 18px;
            /* Kích thước font */
            font-weight: bold;

        }

        .home-hover:hover {
            text-decoration: none;

        }

        /* .img-border:hover {

            box-shadow: 0 0 10px #2f302f;

        } */
    </style>
@endsection
@section('content')

    <div class="row row-cols-1 row-cols-sm-3 row-cols-md-5 g-5 text-center">

        @foreach ($danhmucTruyen as $danhmuc)
            <div class="col">
                <a class="home-hover" href="{{ route('danhmuc', ['slugDM' => $danhmuc->slug]) }}">
                    <img class="img-border" style="width: 180px; height: 120px;" src="{{ asset('admin/img/bookopen1.png') }}"
                        alt="">

                </a>
                <span class="text-category">{{ $danhmuc->name }}</span>
            </div>
        @endforeach

        @foreach ($theLoai as $tl)
            <div class="col">
                <a class="home-hover" href="{{ route('theloai', ['slugTL' => $tl->slug]) }}">
                    <img class="img-border" style="width: 180px; height: 120px;" src="{{ asset('admin/img/bookopen1.png') }}" alt="">

                </a>
                <span class="text-category">{{ $tl->name }}</span>
            </div>
        @endforeach
    </div>
@endsection
