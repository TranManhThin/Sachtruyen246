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
        $('#formDangKy').submit(function(event) {
            event.preventDefault();
            var elementValue = $(this);
            // var repass = $('#password_confirmation').val();

            // $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('dangKyTK') }}',
                type: 'post',
                data: elementValue.serializeArray(),
                dataType: 'json',
                success: (response) => {
                    console.log(response);
                    if (response.status == true) {

                        $("#fullname").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        $("#phone").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        $("#email").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        $("#password").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");
                        $("#password_confirmation").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback d-block').html("");

                        Swal.fire({
                            title: "Đăng nhập và trở lại trang chủ?",
                            showDenyButton: false,
                            showCancelButton: true,
                            confirmButtonText: "Có",
                            denyButtonText: `Không`
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('trangchu') }}';
                            } else{
                                location.reload(true);
                            }
                        });
                    } else {
                        var errors = response['errors'];
                        if (errors['fullname']) {
                            $("#fullname").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors['fullname']);
                        } else {
                            $("#fullname").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }

                        if (errors['phone']) {
                            $("#phone").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors['phone']);
                        } else {
                            $("#phone").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }

                        if (errors['email']) {
                            $("#email").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors['email']);
                        } else {
                            $("#email").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }

                        if (errors['password']) {
                            $("#password").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors['password']);
                        } else {
                            $("#password").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback d-block').html("");
                        }

                        if (errors['password_confirmation']) {
                            $("#password_confirmation").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback d-block').html(errors[
                                    'password_confirmation']);
                        } else {
                            $("#password_confirmation").removeClass('is-invalid').siblings('p')
                                .removeClass(
                                    'invalid-feedback d-block').html("");
                        }


                    }
                },
                error: (response) => {
                    console.log('Something went wrong!');
                }
            });
        })
    </script>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Đăng ký</li>
        </ol>
    </nav>

    <div class="row" style="justify-content: center">
        <div class="col-lg-7 mb-5 mb-lg-5">
            <div class="card">
                <div class="card-body py-5 px-md-5">
                    <form method="POST" id="formDangKy" action="">

                        <!-- 2 column grid layout with text inputs for the first and last names -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="form3Example1">Họ tên</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control"
                                        value="{{ old('fullname') }}" />
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="form3Example2">Số điện thoại</label>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone') }}" />
                                    <p></p>
                                </div>
                            </div>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email') }}" />
                            <p></p>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example4">Mật khẩu</label>
                            <input type="password" id="password" name="password" class="form-control"
                                value="{{ old('password') }}" />
                            <p></p>
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example4">Nhập lại mật khẩu</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" value="{{ old('re_password') }}" />
                            <p></p>
                        </div>
                        <!-- Checkbox -->
                        {{-- <div class="form-check d-flex justify-content-center mb-4">
                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example33" checked />
                <label class="form-check-label" for="form2Example33">
                  Subscribe to our newsletter
                </label>
              </div> --}}

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4">
                            Đăng ký
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
