@extends('admin.layout.admin')
@section('title', 'Thêm chapter')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
@endsection
@section('page-content')
<h1 style="color: blue">Thêm chương</h1>
    <form action="{{ route('chapter.update',['chapter'=>$chapter->id]) }}" name="formPost" id="formPost" method="POST" enctype="multipart/form-data" >
        @csrf
        @method('PUT')
        {{-- @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif --}}
        <div class="mb-3">
            <label for="" class="form-label">Tên chương</label>
            <input onkeyup="changeToSlug()" type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" aria-describedby="categoryHelp" value="{{ $chapter->name }}">
            @error('name')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Slug chương</label>
            <input type="text" class="form-control" id="slug" name="slug" aria-describedby="categoryHelp" value="{{ $chapter->slug }}"
                readonly>
            @error('desc')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Tóm tắt chương</label>
            <textarea name="desc" id="desc" rows="2" class="form-control @error('desc') is-invalid @enderror"
                style="resize: none">{{ $chapter->description }}</textarea>
            @error('desc')
                <p class="invalid-feedback d-block">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Nội dung chương</label>
            <textarea  name="content" id="editor" rows="10" class="form-control content @error('content') is-invalid @enderror"
                style="resize: none">{{ $chapter->content }}</textarea>
                @error('content')
                <p class="invalid-feedback d-block">{{ $message }}</p>
                @enderror
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Thuộc truyện</label>

            <select name="story_id" id="story_id" class="custom-select">

                @foreach ($story as $sto)
                    <option {{ ($chapter->story->id == $sto->id)?'selected':'' }} value="{{ $sto->id }}">{{ $sto->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 form-select">
            <label for="form-label">Trạng thái</label>
            <select name="active" id="active" class="custom-select">
                @if ($chapter->active == 1)
                <option selected value="1">Kích hoạt</option>
                <option value="0">Không kích hoạt</option>
                @else
                <option value="1">Kích hoạt</option>
                <option selected value="0">Không kích hoạt</option>
                @endif

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

                    // if (!response || response.error) {
                    //     return reject(response && response.error ? response.error.message : genericErrorText);
                    // }

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
@endsection
