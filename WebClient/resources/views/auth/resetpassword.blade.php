@extends('shared/layout')
@section('title','Login')
@section('body')
<div class="container d-flex align-items-center justify-content-center" style="height: 80vh;">
    <div class="row align-items-center text-dark text-center bg-white rounded align-self-center shadow" style="max-width: 95vh;">
        <div class="col p-0">
            <img src="/images/auth/loginpage.jpg" class="img-fluid rounded-start">
        </div>
        <div class="col">
            <div class="mb-3">
                <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Reset Password</span>
            </div>
            <form method="post" id="form-sb" class="border mb-2 rounded p-4">
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
            <div class="mt-3" style="font-size: 2vh;"><label for="">If you don't have account, please </label>
            <a href="/auth/register">Register</a>
            </div>
        </div>
    </div>
</div>
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