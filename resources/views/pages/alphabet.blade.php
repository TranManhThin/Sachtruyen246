@extends('layout')
@section('js')
    <script>
        $(document).ready(function() {
            var theLoai = $('#loai').val();
            $('#loai').change(() => {
                theLoai = $('#loai').val();
            })
            $('.tabsAlpha').click(function() {
                var kyTu = $(this).data('abc');
                const _token = $('input[name="_token"]').val();


                $.ajax({
                    url: '{{ route('alphabetSearch') }}',
                    method: 'POST',
                    data: {
                        kyTu: kyTu,
                        theLoai: theLoai,
                        _token: _token
                    },
                    success: function(data) {
                        $('#tabs_' + kyTu + '').html(data);
                    }

                });
            });
        });

        $(document).on('click', '.watch_book', function() {
            var book_id = $(this).attr('id');
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ route('xem-sach-nhanh') }}',
                method: 'post',
                dataType: 'json',
                data: {
                    book_id: book_id,
                    _token: _token
                },
                success: (data) => {
                    $('#tieudesach').html(data.tieudesach);
                    $('#noidungsach').html(data.noidungsach);
                }

            });
        });
    </script>
@endsection
@section('content')
    @php
        $letter = range('A', 'Z');
        $num = range('0', '9');
        $chars = array_merge($letter, $num);
    @endphp
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <h3>Lọc theo:</h3>
                <form action="">
                    @csrf
                    <select class="custom-select" name="loai" id="loai">
                        <option value="truyen">Truyện</option>
                        <option value="sach">Sách</option>
                    </select>
                </form>
            </div>
            <div class="col-md-9">
                <form action="">
                    @csrf
                    <nav class="nav nav-tabs">
                        @foreach ($chars as $char)
                            <a style="text-decoration-line: none; text-decoration: none"
                                href="#search_with_{{ $char }}" class="nav-item nav-link tabsAlpha"
                                data-toggle="tab" data-abc="{{ $char }}">
                                {{ $char }}
                            </a>
                        @endforeach
                    </nav>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tab-content mt-3">
                @foreach ($chars as $char)
                    <div class="tab-pane container" id="search_with_{{ $char }}">
                        <hr>
                        {{-- <h3>Danh mục: {{ $danhmuc->name }}</h3> --}}
                        <div class="container">

                            <div id="tabs_{{ $char }}" class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">

                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title w-100" id="staticBackdropLabel" style="text-align: center">
                        <div id="tieudesach"
                            style="font-size: 30px; font-weight: bold;font-family: 'Patrick Hand', cursive;text-align: center; color: red !important">
                        </div>
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="noidungsach" style="color: black !important">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
@endsection
