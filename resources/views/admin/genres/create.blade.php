@extends('admin.layout.admin')
@section('title','Thêm thể loại')

@section('page-content')
<form action="" name="formPost" id="formPost" method="POST">
    @csrf
    <div class="mb-3">
      <label for="" class="form-label">Tên thể loại</label>
      <input onkeyup="changeToSlug()" type="text" class="form-control" id="name" name="name" aria-describedby="categoryHelp" value="{{ old('name') }}">
      <p></p>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Slug thể loại</label>
        <input type="text" class="form-control" id="slug" name="slug" aria-describedby="categoryHelp" readonly>
        <p></p>
      </div>
    <div class="mb-3">
      <label for="" class="form-label">Mô tả thể loại</label>
      <input type="text" class="form-control" id="desc" name="desc" value="{{ old('desc') }}">
      <p></p>
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
    <script>
        $("#formPost").submit(function(e){
            e.preventDefault();
            var elementForm = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('genre.store') }}',
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
                        alert(response['message']);
                        $('#name').val('');
                        $('#desc').val('');
                        $('#slug').val('');
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