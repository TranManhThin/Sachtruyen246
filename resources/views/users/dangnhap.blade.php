@extends('layout')
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
    <script>
        $('#formDangNhap').submit(function (event){
            event.preventDefault();
            var valueForm = $(this);
            $.ajax({
                url: '{{ route('dangNhapTK') }}',
                type: 'post',
                data: valueForm.serializeArray(),
                dataType: 'json',
                success: function(response){
                    if (response.status == true) {
                        if (response.code == 200) {
                            $('email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback d-block').html('');
                            $('password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback d-block').html('');
                            alert(response.message)
                            window.location.href = '{{ route('trangchu') }}';
                        }else if(response.code == 400){
                            Swal.fire("Tài khoản/Mật khẩu không đúng!");
                        }
                    }else{
                        var errors = response['errors'];
                        if (errors['email']) {
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback d-block').html(errors['email']);
                        }else{
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback d-block').html('');
                        }

                        if (errors['password']) {
                            $('#password').addClass('is-invalid').siblings('p').addClass('invalid-feedback d-block').html(errors['password']);
                        }else{
                            $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback d-block').html('');
                        }
                    }
                },
                error: function(){
                    console.log('Wrong!');
                }
            });
        });
    </script>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
      <li class="breadcrumb-item active" aria-current="page">Đăng nhập</li>
    </ol>
</nav>

<div class="row" style="justify-content: center">
    <div class="col-lg-7 mb-5 mb-lg-5">
        <div class="card">
          <div class="card-body py-5 px-md-5">
            <form method="POST" id="formDangNhap">
              <!-- Email input -->
              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example3">Email</label>
                <input type="email" id="email" name="email" class="form-control" />
                <p></p>
              </div>

              <!-- Password input -->
              <div class="form-outline mb-4">
                <label class="form-label" for="form3Example4">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" />
                <p></p>
              </div>

              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block mb-4">
                Đăng nhập
              </button>
              <!-- Register buttons -->
              <div class="text-center">
                <p>or sign up with:</p>
                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-facebook-f"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-google"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-twitter"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-github"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
</div>
@endsection
