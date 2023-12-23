@extends('shared/layout')
@section('title','Forgot password')
@section('class-body')
    id="theme8" style="color:black !important;"
@endsection
@section('body')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Welcome back!</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item text-white"><a href="/auth/login">Login</a></li>
                <li class="breadcrumb-item active text-white">Forgotpassword</li>
            </ol>
        </div>
        <!-- Single Page Header End -->
        <!-- Single Product Start -->
        <div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8 col-xl-8">
                <div class="row g-4 bg-light rounded">
                    <div id="img-auth" class="col-lg-6 p-0 m-0">
                        <div class="rounded">
                            <a>
                                <img src="/images/auth/loginpage.jpg" class="img-fluid w-100 rounded">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="mb-3">
                            <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Forgot password</span>
                        </div>
                        <form id="forgotpassword" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" name="email" id="email" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Email..." required>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-outline-success login-btn">Send reset password to email!</button>
                        </div>
                        </form>
                        <div class="mt-3 mb-3" style="font-size: 2vh;"><label for="">If you don't have account, please </label>
                        <a href="/auth/register">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Single Product End -->
@section('scripts')
<script>
$('form').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
}

    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        type: 'post',
        url: '/auth/forgotpassword',
        data: formData,
        processData: false, 
        contentType: false, 
        success: function(data) {
            if(data.success){
            alert('Đã gửi email yêu cầu đổi mật khẩu');
            window.location.href='/auth/login';
            }else{
                console.log(data);
                alert('Email của bạn vừa nhập chưa đăng ký tài khoản!');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            alert('Lỗi');
        }
    });
});


</script>
@endsection
@endsection