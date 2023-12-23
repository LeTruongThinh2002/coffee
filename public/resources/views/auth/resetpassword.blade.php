@extends('shared/layout')
@section('title','Reset password')
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
                <li class="breadcrumb-item active text-white">Resetpassword</li>
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
                                <img src="/images/auth/moon2.png" class="img-fluid w-100 rounded">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="mb-3">
                            <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Reset password</span>
                        </div>
                        <form method="post" id="form-sb" method="post">
                        @csrf
                        <input type="hidden" name="token" id="token">
                        <div class="form-group mt-3">
                            <label for="password">New password</label>
                            <input type="password" name="password" id="password" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Password..." required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="confirmPassword">Confirm new password</label>
                            <input type="password" id="confirmPassword" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Confirm password..." required>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" id="repassword" class="btn btn-outline-success login-btn">Reset password</button>
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
    window.onload = function() {
    var urlParams = new URLSearchParams(window.location.search);
    var token = urlParams.get('token');
    document.getElementById('token').value = token;
};

document.getElementById('form-sb').addEventListener('submit', function(event) {
    event.preventDefault();

    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Mật khẩu mới và mật khẩu xác nhận không giống nhau. Vui lòng kiểm tra lại.');
        return;
    }
    var formData = new FormData(this);
for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
}
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: '/auth/doResetpassword',
            method: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(data) {
                console.log(data);
                if(data.success){
                    alert('Reset password successfully!');
                    window.location.href='/auth/login';
                }
                else
                    alert(data.error);
            },
            error: function(error) {
                alert('error');
                console.log(error);
            }
        });
});


</script>
@endsection
@endsection