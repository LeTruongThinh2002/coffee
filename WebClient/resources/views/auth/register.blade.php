@extends('shared/layout')
@section('title','Register')
@section('body')
<div class="container d-flex align-items-center justify-content-center" style="height: 80vh;">
    <div class="row align-items-center text-dark text-center bg-white rounded align-self-center shadow" style="max-width: 95vh;">
        <div class="col p-0" >
            <img src="/images/auth/moon2.png" class="rounded-start img-fluid">
        </div>
        <div class="col">
            <div class="mb-3">
                <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy3.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Register</span>
            </div>
            <form id="register" method="post" class="border mb-2 rounded p-4">
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
            <div class="mt-2" style="font-size: 2vh;">
            <label for="">If you have an account, please </label>
            <a href="/auth/login">Login!</a>
            </div>
        </div>
    </div>
</div>
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