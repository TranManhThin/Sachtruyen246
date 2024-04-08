@extends('layout')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('theloai',['slugTL'=>$truyen->genre->slug]) }}">{{ $truyen->genre->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('danhmuc',['slugDM'=>$truyen->category->slug]) }}">{{ $truyen->category->name }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('xemtruyen',['slug'=>$truyen->slug]) }}">{{ $truyen->name }}</a></li>
        <li class="breadcrumb-item active">{{ $chapterTruyen->name }}</li>

      </ol>
</nav>
<div class="row">
    @php
        $danhSachRouteChapter = [];
        for($i=0;$i<count($chapter);$i++){
            $danhSachRouteChapter[$i] = $chapter[$i]->slug;
        }

        $request = Request::segments();
        $chuongHienTai = end($request);

        $viTriHienTai = 0;
        for($i=0;$i<count($danhSachRouteChapter);$i++){
            if ($chuongHienTai == $danhSachRouteChapter[$i]) {
                $viTriHienTai = $i;
            }
        }


        $chuongTruoc = '';
        $chuongSau = '';
        if (count($danhSachRouteChapter)==1) {
            $chuongTruoc = 0;
            $chuongSau = 0;
        }else{
            if ($viTriHienTai==0) {
           $chuongTruoc = $danhSachRouteChapter[$viTriHienTai];
           $chuongSau = $danhSachRouteChapter[$viTriHienTai+1];
        }
        else if($viTriHienTai == count($danhSachRouteChapter)-1){
            $chuongTruoc = $danhSachRouteChapter[$viTriHienTai-1];
            $chuongSau = $danhSachRouteChapter[$viTriHienTai];
        }
        else{
            $chuongTruoc = $danhSachRouteChapter[$viTriHienTai-1];
            $chuongSau = $danhSachRouteChapter[$viTriHienTai+1];
        }
        }


        // $chuongTruoc = ($viTriHienTai==0)?$danhSachRouteChapter[$viTriHienTai]:$danhSachRouteChapter[$viTriHienTai-1];
        // $chuongSau = ($$viTriHienTai==count($danhSachRouteChapter))?$danhSachRouteChapter[$viTriHienTai]:$danhSachRouteChapter[$viTriHienTai+1];
    @endphp
    <div class="col-md-12">
        <h1>Truyện: {{ $truyen->name }}</h1>
        <p>Chương hiện tại: {{ $chapterTruyen->name }}</p>
        <div class="col-12 text-center">
            <div class="btn-group">
                <a id={{ ($viTriHienTai==0)?'disabled':'none' }}  href="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chuongTruoc]) }}" class="btn btn-primary"><i class="fa fw fa-backward" aria-hidden="true"></i></a>
                <select name="chonChuong" id="selectChapter" class="btn btn-primary form-control selectChapter">
                    @foreach ($chapter as $chap)
                        <option {{ ($chapterTruyen->id==$chap->id)?'selected':'' }} value="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chap->slug]) }}">{{ $chap->name }}</option>
                    @endforeach
                </select>
                <a id={{($viTriHienTai==count($danhSachRouteChapter)-1)?'disabled':'none1' }} href="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=> $chuongSau]) }}" class="btn btn-primary"><i class="fa fw fa-forward" aria-hidden="true"></i></a>
            </div>
            <style>
                /* CSS để ẩn liên kết */
                #disabled, #disabled1{
                    pointer-events: none; /* Vô hiệu hóa sự kiện click */
                    color: currentColor; /* Đổi màu chữ để chỉ ra rằng nó đã bị vô hiệu hóa */
                    text-decoration: none;
                    opacity: 0.5 ; /* Loại bỏ gạch chân */
                }

            </style>

                {{-- <label for="">Chọn chương</label>
                <select name="chonChuong" id="selectChapter" class="custom-select selectChapter">
                    @foreach ($chapter as $chap)
                        <option {{ ($chapterTruyen->id==$chap->id)?'selected':'' }} value="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chap->slug]) }}">{{ $chap->name }}</option>
                    @endforeach
                </select> --}}


        </div>
        <div style="text-align: center">
            <p>---------------------(*)---------------------</p>
        </div>

        {{-- <div class="col-md-8">

            <div class="form-group">
                <label for="">Chọn chương</label>
                <select name="chonChuong" id="selectChapter" class="custom-select selectChapter">
                    @foreach ($chapter as $chap)
                        <option {{ ($chapterTruyen->id==$chap->id)?'selected':'' }} value="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chap->slug]) }}">{{ $chap->name }}</option>
                    @endforeach
                </select>

            </div>

        </div> --}}
        <div class="noidung">
            {!! $chapterTruyen->content !!}
        </div>
        <div style="text-align: center">
            <p>---------------------(*)---------------------</p>
        </div>
        <div class="col-12 text-center">
            <div class="btn-group">
                <a id={{ ($viTriHienTai==0)?'disabled1':'none' }}  href="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chuongTruoc]) }}" class="btn btn-primary"><i class="fa fw fa-backward" aria-hidden="true"></i></a>
                <select name="chonChuong" id="selectChapter" class="btn btn-primary form-control selectChapter">
                    @foreach ($chapter as $chap)
                        <option {{ ($chapterTruyen->id==$chap->id)?'selected':'' }} value="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chap->slug]) }}">{{ $chap->name }}</option>
                    @endforeach
                </select>
                <a id={{($viTriHienTai==count($danhSachRouteChapter)-1)?'disabled1':'none1' }} href="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=> $chuongSau]) }}" class="btn btn-primary"><i class="fa fw fa-forward" aria-hidden="true"></i></a>
            </div>

                {{-- <label for="">Chọn chương</label>
                <select name="chonChuong" id="selectChapter" class="custom-select selectChapter">
                    @foreach ($chapter as $chap)
                        <option {{ ($chapterTruyen->id==$chap->id)?'selected':'' }} value="{{ route('xemchuong',['slug'=>$truyen->slug,'slugChapter'=>$chap->slug]) }}">{{ $chap->name }}</option>
                    @endforeach
                </select> --}}



        </div>


    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="fb-share-button" data-href="{{ URL::current() }}" data-layout="button_count" data-size="large">
            <a target="_blank"
                href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F127.0.0.1%3A8000%2Fxem-truyen%2Fong-gia-va-bien-ca%2Fchapter-1-ong-gia-ra-khoi&amp;src=sdkpreparse"
                class="fb-xfbml-parse-ignore">Chia sẻ</a>
        </div>
        <div class="fb-comments" data-href="{{ URL::current() }}" data-width="100%" data-numposts="50"></div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $('.selectChapter').on('change',function (){
            var $url = $(this).val();
            window.location = $url;
        })
    </script>
@endsection


