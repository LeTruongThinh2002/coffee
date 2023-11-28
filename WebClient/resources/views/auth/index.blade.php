@extends('shared/layout')
@section('title','Infomation')
@section('body')
<div class="container d-flex align-items-center justify-content-center" style="height: 80vh;">
    <div class="row align-items-center text-dark text-center bg-white rounded align-self-center shadow" style="max-width: 95vh;">
        <div class="col p-0">
            <img src="/images/auth/loginpage.jpg" class="img-fluid rounded-start">
        </div>
        <div class="col">
            <div class="mb-3">
                <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Information</span>
            </div>
            <form method="post" class="border mb-2 rounded p-4">
                @csrf
                <div class="form-group d-flex justify-content-center">
                    <div class="profile-container rounded-circle image-container">
                        <img class="profile-image" src="/images/user/{{$u['img']}}" alt="Profile Image">
                        <input type="file" class="profile-image ip-img" name="ImageUrl" id="{{$u['id']}}">
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label>Name: {{$u['name']}}</label>
                </div>
                <div class="form-group mt-2">
                    <label>Email: {{$u['email']}}</label>
                    @if($u['email_verify_at']===null)
                    <label class="text-danger">Please check your email inbox to verify your email!</label>
                    @else
                    <label>Email đã xác thực!</label>
                    <br>
                    <a href="/auth/changeMail" class="btn btn-primary text-light">Change email</a>
                    @endif
                </div>
                <div class="form-group mt-2">
                    <label>Role: {{$u['role']}}</label>
                </div>
                <div class="form-group mt-2">
                    <label>Password: **********</label>
                    <br>
                    <a href="/auth/changepassword" class="btn btn-primary text-light">Change password</a>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $('input[type="file"]').on('change', function() {
    var file = this.files[0];
    var filename = file.name;
    var extension = filename.split('.').pop().toLowerCase();

    if(extension !== 'jpg') {
        alert('Vui lòng tải lên một hình ảnh dạng jpg');
        $(this).val('');
        return;
    }

    var formData = new FormData();
    formData.append('ImageUrl', file);
    var csrfToken = $('input[name="_token"]').val();
    formData.append('_token', csrfToken);
    var id=$(this).attr('id');
    var old=document.querySelector('img.profile-image').src;
    formData.append('old', old);
    $.ajax({
        url: '/auth/uploadImage/'+id,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if(data.success){
                document.querySelector('img.profile-image').src = '/images/user/'+data.img;
                alert('Successfully upload your image profile!');
            }
            else
                alert('Failed upload!');
            console.log(data);
        }
    });
});

</script>

@endsection
@endsection