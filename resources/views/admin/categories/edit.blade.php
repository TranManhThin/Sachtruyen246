@extends('admin.layout.admin')
@section('title','Sửa danh mục')
@section('page-content')
<form action="" name="formPost" id="formPost" method="POST">
    @csrf
    <div class="mb-3">
      <label  for="" class="form-label">Tên danh mục</label>
      <input onkeyup="changeToSlug()" type="text" class="form-control" id="name" name="name" aria-describedby="categoryHelp" value="{{ $categoryById->name }}">
      <p></p>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Slug danh mục</label>
        <input type="text" class="form-control" id="slug" name="slug" aria-describedby="categoryHelp" value="{{ $categoryById->slug }}" readonly>
        <p></p>
      </div>
    <div class="mb-3">
      <label for="" class="form-label">Mô tả danh mục</label>
      <input type="text" class="form-control" id="desc" name="desc" value="{{ $categoryById->description }}">
      <p></p>
    </div>
    <div class="mb-3 form-select">
        <label for="form-label">Trạng thái</label>
      <select name="active" id="active" class="custom-select">
        @if ($categoryById->active == 1)
        <option selected value="1">Kích hoạt</option>
        <option value="0">Không kích hoạt</option>
        @else
        <option  value="1">Kích hoạt</option>
        <option selected value="0">Không kích hoạt</option>
        @endif
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection
@section('js')
    <script src="{{ asset('admin/js/autoSlug.js') }}"></script>
    <script>
        $("#formPost").submit(function(e){
            e.preventDefault();
            var elementForm = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('category.update',['category'=> $categoryById->id]) }}',
                type: 'PUT',
                data: elementForm.serializeArray(),
                dataType: 'json',
                success: function (response){
                    $("button[type=submit]").prop('disabled', false);
                    if (response['status'] == true) {

                        $("#name").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        $("#desc").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        alert(response['message']);
                        $('#name').val('');
                        $('#desc').val('');
                        $('#active').val($('#active option:first').val());
                        window.location.href = '{{ route('category.index') }}';

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
                                .addClass('invalid-feedback d-block').html(errors['name']);
                        }else{
                            $("#desc").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }
                    }
                },
                error: function (jqXHR, exception){
                    console.log('Something went wrong!');
                }
            })
        })
    </script>
@endsection
