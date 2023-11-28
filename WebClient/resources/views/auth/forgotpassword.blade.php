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
                <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Forgot Password</span>
            </div>
            <form method="post" class="border mb-2 rounded p-4">
                @csrf
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Email..." required>
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-outline-success login-btn">Send reset password to email!</button>
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
$('form').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
}

    $.ajax({
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