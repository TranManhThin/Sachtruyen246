@extends('admin.layout.admin')
@section('title', 'Sửa truyện')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
    <link rel="stylesheet" href="{{ asset('admin/vendor/select2/select2.min.css') }}">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(55, 13, 239);
            color: white;
        }
    </style>
@endsection
@section('page-content')
    <form action="{{ route('story.update', ['story' => $storyById->id]) }}" name="formPost" id="formPost" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-3">
            <label for="" class="form-label">Tên truyện</label>
            <input onkeyup="changeToSlug()" type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" aria-describedby="categoryHelp" value="{{ $storyById->name }}">
            @error('name')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Slug truyện</label>
            <input type="text" class="form-control" id="slug" name="slug" aria-describedby="categoryHelp"
                value="{{ $storyById->slug }}" readonly>
            @error('desc')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Tác giả</label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author"
                aria-describedby="categoryHelp" value="{{ $storyById->author }}">
            @error('author')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Từ khóa</label>
            <select name="keywords[]" class="form-control tag_select_2" multiple="multiple">
                @php
                    $tukhoa = explode(',', $storyById->keyword);
                @endphp
                @foreach ($tukhoa as $value)
                    <option value="{{ $value }}" selected>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Mô tả truyện</label>
            <textarea name="desc" id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror"
                style="resize: none">{{ $storyById->description }}</textarea>
            <p></p>
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Truyện nổi bật</label>
            <select name="story_hot" id="active" class="custom-select">
                @if ($storyById->story_hot == 0)
                <option selected  value="0">Truyện mới</option>
                <option  value="1">Truyện nổi bật</option>
                <option  value="2">Truyện xem nhiều</option>
                @elseif ($storyById->story_hot == 1)
                <option   value="0">Truyện mới</option>
                <option  selected value="1">Truyện nổi bật</option>
                <option  value="2">Truyện xem nhiều</option>
                @else
                <option   value="0">Truyện mới</option>
                <option   value="1">Truyện nổi bật</option>
                <option selected  value="2">Truyện xem nhiều</option>
                @endif

            </select>
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Trạng thái</label>
            <select name="active" id="active" class="custom-select">
                @if ($storyById->active == 1)
                    <option selected value="1">Kích hoạt</option>
                    <option value="0">Không kích hoạt</option>
                @else
                    <option value="1">Kích hoạt</option>
                    <option selected value="0">Không kích hoạt</option>
                @endif
            </select>
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Danh mục</label>
            <select name="category_id" id="category_id" class="custom-select">
                @foreach ($category as $cate)
                    <option {{ $cate->id == $storyById->category_id ? 'selected' : '' }} value="{{ $cate->id }}">
                        {{ $cate->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Thể loại</label>
            <select name="genre_id" id="genre_id" class="custom-select">
                @foreach ($genres as $genre)
                    <option {{ $genre->id == $storyById->genre_id ? 'selected' : '' }} value="{{ $genre->id }}">
                        {{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="form-label">Hình ảnh</label>
            <input type="file" name="image_path" id="image_path"
                class="form-control @error('image_path') is-invalid @enderror">
            @error('image_path')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
            <br>
            <img src="{{ $storyById->image }}" alt="" class="rounded" style="box-shadow:0 0 10px rgba(0, 0, 0, 0.5); ">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
@section('js')
    <script src="{{ asset('admin/js/autoSlug.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
    <script src="{{ asset('admin/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(".tag_select_2").select2({
            tags: true,
            tokenSeparators: [',']
        });
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
