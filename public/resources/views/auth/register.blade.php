@extends('shared/layout')
@section('title','Register')
@section('class-body')
    id="theme8" style="color:black !important;"
@endsection
@section('body')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Welcome to register!</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-white">Register</li>
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
                            <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Register</span>
                        </div>
                        <form id="register" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Name..." required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Email..." pattern=".+(gmail\.com|yahoo\.com)$" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Password..." minlength="8" required>    
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-outline-success">Register</button>
                        </div>
                        </form>
                        <div class="mt-3 mb-3" style="font-size: 2vh;"><label for="">If you have an account, please </label>
                        <a href="/auth/login">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Single Product End -->

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast hide" Category="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="/images/page/tenor.gif" class="rounded-circle me-2 img-fluid" style="width: 4.5vh; height: 4.5vh;">
      <strong class="me-auto text-danger">Thông báo</strong>
      <small></small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
    </div>
  </div>
</div>
@section('scripts')
<script>

    $(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();
        var form_data = $(this).serialize(); 
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: '/auth/register',
            method: 'POST',
            data: form_data,
            success: function(data) {
                console.log(data);
                if(data.success){
                    alert('Register successfully!');
                    window.location.href='/auth/login';
                }
                else
                    showToast('Account registration failed, please check the information!');
            },
            error: function(error) {
                showToast('Account already use!');
            }
        });
    });
});
function showToast(active) {
  $('#liveToast div.toast-body').text(active);
  $('#liveToast').toast('show');
  startTime = new Date();
  updateTime();
  setInterval(updateTime, 1000);
};
var startTime;
function updateTime() {
  var now = new Date();
  seconds = Math.round((now - startTime) / 1000);
  var timeString = 'just now';
  if (seconds > 1) {
    timeString = seconds + ' seconds later';
  }
  document.querySelector('.toast-header small').textContent = timeString;
}
</script>
@endsection
@endsection