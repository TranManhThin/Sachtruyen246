@extends('admin.layout.admin')
@section('title', 'Thêm sách')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
    <link rel="stylesheet" href="{{ asset('admin/vendor/select2/select2.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(55, 13, 239);
            color: white;
        }
    </style>
@endsection
@section('page-content')
    <form action="{{ route('book.store') }}" name="formPost" id="formPost" method="POST" enctype="multipart/form-data">
        @csrf
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="" class="form-label">Tên sách</label>
            <input onkeyup="changeToSlug()" type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" aria-describedby="categoryHelp" value="{{ old('name') }}">
            @error('name')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Slug sách</label>
            <input type="text" class="form-control" id="slug" name="slug" aria-describedby="categoryHelp"
                readonly>
            @error('desc')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Tác giả</label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author"
                aria-describedby="categoryHelp" value="{{ old('author') }}">
            @error('author')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Từ khóa</label>
            <select name="keywords[]"
                class="form-control @error('keywords')
            is-invalid
            @enderror tag_select_2"
                multiple="multiple">

            </select>
            @error('keywords')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Mô tả sách</label>
            <textarea name="desc" id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror"
                style="resize: none">{{ old('desc') }}</textarea>
            @error('desc')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Trạng thái</label>
            <select name="active" id="active" class="custom-select">
                <option value="1">Kích hoạt</option>
                <option value="0">Không kích hoạt</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="form-label">Hình ảnh</label>
            <input type="file" name="image_path" id="image_path"
                class="form-control @error('image_path') is-invalid @enderror">
            @error('image_path')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nội dung</label>
            <textarea name="content" id="summernote" class="form-group @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
@section('js')
    <script src="{{ asset('admin/js/autoSlug.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
    <script src="{{ asset('admin/vendor/select2/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
    <script>
        $(".tag_select_2").select2({
            tags: true,
            tokenSeparators: [',']
        });
        $('#summernote').summernote();
        // ClassicEditor
        //     .create(document.querySelector('#editor'))
        //     .then(editor => {
        //         console.log('Editor was initialized', editor);
        //     })
        //     .catch(err => {
        //         console.error(err.stack);
        //     });
    </script>
    {{-- <script>
        $('#formPost').click(function() {
            $.ajax({
                url: '{{ route('story.store') }}',
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    if (data.code == 200) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Your work has been saved",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function(){

                }
            });
        })
    </script> --}}
    {{-- <script>
        $("#formPost").submit(function(e){

            e.preventDefault();
            var elementForm = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('story.store') }}',
                type: 'post',
                data: elementForm.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false);
                    if (response['status'] == true) {
                        $("#name").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        $("#desc").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        $("#image_path").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        alert(response['message']);
                        $('#name').val('');
                        $('#desc').val('');
                        $('#active').val($('#active option:first').val());

                    }
                    else{
                        var errors = response['errors'];
                        if (errors['name']) {
                            $("#name").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors['name']);
                        }else{
                            $("#name").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }

                        if (errors['desc']) {
                            $("#desc").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors['desc']);
                        }else{
                            $("#desc").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }

                        if (errors['image_path']) {
                            $("#image_path").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors['image_path']);
                        }else{
                            $("#image_path").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }
                    }
                },
                error: function (jqXHR, exception){
                    console.log('Something went wrong!');
                }
            })
        })


    </script> --}}
@endsection
