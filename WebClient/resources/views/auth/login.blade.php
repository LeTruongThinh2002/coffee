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
                <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Login</span>
            </div>
            <form method="post" class="border mb-2 rounded p-4">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Email..." required>
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Password..." required>
                </div>
                <div class="form-group form-check mt-2">
                    <input class="me-1" type="checkbox" name="rem" id="rem">
                    <label for="rem">Remember me!</label> 
                </div>
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-outline-success login-btn">Login</button>
                </div>
            </form>
            <div class="mt-3" style="font-size: 2vh;"><label for=""></label>
            <a href="/auth/forgotpassword">Forgot password!</a>
            </div>
            <div class="mt-3" style="font-size: 2vh;"><label for="">If you don't have account, please </label>
            <a href="/auth/register">Register</a>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        var rem = $('#rem').is(':checked');
        console.log(rem);
        $.ajax({
            url: '/auth/login', // Thay đổi thành endpoint của bạn
            type: 'POST',
            data: {
                email: email,
                password: password,
                rem: rem,
                _token: '{{ csrf_token() }}' // Thêm token CSRF của bạn
            },
            success: function(response) {
                if(response.success)
                    window.location.href='/auth';
                else
                    {
                        console.log(response.msg);
                        alert(response.msg);
                    }
            },
            error: function(error) {
                console.log(email);
                console.log(password);
                console.log(rem);
                console.log(error);
            }
        });
    });
});

</script>
@endsection
@endsection