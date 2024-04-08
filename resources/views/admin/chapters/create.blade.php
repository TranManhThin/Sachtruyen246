@extends('admin.layout.admin')
@section('title', 'Thêm chapter')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
@endsection
@section('page-content')
    <h1 style="color: blue">Thêm chương</h1>
    <form action="{{ route('chapter.store') }}" name="formPost" id="formPost" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif --}}
        <div class="mb-3">
            <label for="" class="form-label">Tên chương</label>
            <input onkeyup="changeToSlug()" type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" aria-describedby="categoryHelp" value="{{ old('name') }}">
            @error('name')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Slug chương</label>
            <input type="text" class="form-control" id="slug" name="slug" aria-describedby="categoryHelp"
                readonly>
            @error('desc')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Tóm tắt chương</label>
            <textarea name="desc" id="desc" rows="2" class="form-control @error('desc') is-invalid @enderror"
                style="resize: none">{{ old('desc') }}</textarea>
            @error('desc')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nội dung chương</label>
            <textarea name="content" id="editor" class="form-group @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Thuộc truyện</label>
            <select name="story_id" id="story_id" class="custom-select">
                @foreach ($story as $sto)
                    <option value="{{ $sto->id }}">{{ $sto->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Trạng thái</label>
            <select name="active" id="active" class="custom-select">
                <option value="1">Kích hoạt</option>
                <option value="0">Không kích hoạt</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
@section('js')
    <script src="{{ asset('admin/js/autoSlug.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
    <script>
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }

            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();

                xhr.open('POST', "{{ route('upload', ['_token' => csrf_token()]) }}", true);
                xhr.responseType = 'json';
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${ file.name }.`;

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

                    resolve(response);
                });

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            _sendRequest(file) {
                const data = new FormData();

                data.append('upload', file);

                this.xhr.send(data);
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }
        ClassicEditor
            .create(document.querySelector('#editor'),{
                extraPlugins: [ MyCustomUploadAdapterPlugin ],
            })
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(err => {
                console.error(err.stack);
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
