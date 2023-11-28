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
                <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Change new email</span>
            </div>
            <form method="post" id="form-sb" class="border mb-2 rounded p-4">
            @csrf
            <div class="form-group mt-3">
                <label for="newEmail">New email</label>
                <input type="email" name="newEmail" id="newEmail" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="New email..." pattern=".+(gmail\.com|yahoo\.com)$" required>
            </div>
            <div class="form-group mt-3">
                <label for="password">Your password</label>
                <input type="password" name="password" id="password" class="form-control rounded-pill bg-white text-dark shadow-none" placeholder="Password..." required>
            </div>
            <div class="form-group mt-4">
                <button type="submit" id="repassword" class="btn btn-outline-success login-btn">Change</button>
            </div>
        </form>
        </div>
    </div>
</div>
@section('scripts')
<script>
document.getElementById('form-sb').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
        $.ajax({
            url: '/auth/changeMail',
            method: 'POST',
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(data) {
                console.log(data);
                if(data.success){
                    alert('Change email successfully!');
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