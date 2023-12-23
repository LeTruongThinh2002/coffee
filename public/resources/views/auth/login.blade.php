@extends('shared/layout')
@section('title','Login')
@section('class-body')
    id="theme8" style="color:black !important;"
@endsection
@section('body')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Welcome back!</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-white">Login</li>
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
                            <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Login</span>
                        </div>
                        <form id="login" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="mb-1" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Email..." required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="mb-1" for="password">Password</label>
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
    $(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        var rem = $('#rem').is(':checked');
        console.log(rem);
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: '/auth/login', // Thay đổi thành endpoint của bạn
            type: 'POST',
            data: {
                email: email,
                password: password,
                rem: rem,
                
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