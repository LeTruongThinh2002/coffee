@extends('shared/layout')
@section('title','Change password')
@section('class-body')
    id="theme8" style="color:black !important;"
@endsection
@section('body')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Welcome back!</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item text-white"><a href="/auth">Auth</a></li>
                <li class="breadcrumb-item active text-white">Changepassword</li>
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
                            <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Change password</span>
                        </div>
                        <form method="post" id="form-sb" method="post">
                        @csrf
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Password..." required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="newpassword">New password</label>
                            <input type="password" name="newpassword" id="newpassword" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Password..." required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="confirmPassword">Confirm new password</label>
                            <input type="password" id="confirmPassword" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Confirm password..." required>
                        </div>
                        <div class="form-group mt-4 mb-3">
                            <button type="submit" id="repassword" class="btn btn-outline-success login-btn">Reset password</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Single Product End -->

@section('scripts')
<script>
document.getElementById('form-sb').addEventListener('submit', function(event) {
    event.preventDefault();

    var password = document.getElementById('newpassword').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Mật khẩu mới và mật khẩu xác nhận không giống nhau. Vui lòng kiểm tra lại.');
        return;
    }
    var formData = new FormData(this);
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: '/auth/changepassword',
            method: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(data) {
                console.log(data);
                if(data.success){
                    alert('Change password successfully!');
                    window.location.href='/auth';
                }
                else
                    alert(data.msg);
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