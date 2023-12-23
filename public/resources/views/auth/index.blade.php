@extends('shared/layout')
@section('title','Account')
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
                                <img src="/images/auth/moon2.png" class="img-fluid w-100 rounded">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="mb-3">
                            <span style="font-weight: bold;color: transparent;font-size: 7vh;background-image: url(/images/page/giphy2.webp); background-position: center; background-size: cover; -moz-background-clip: text; -webkit-background-clip: text;">Account</span>
                        </div>
                        <form class="mb-3" id="account" method="post">
                        @csrf
                        <div class="form-group d-flex justify-content-center">
                            <div class="image-container profile-containt rounded-circle">
                                <img class="profile-img" src="/images/user/{{$u['img']}}" alt="Profile Image">
                                <input type="file" class="profile-img ip-img" name="ImageUrl" id="{{$u['id']}}">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label>Name: {{$u['name']}}</label>
                        </div>
                        <div class="form-group mt-2">
                            <label class="mb-2">Email: {{$u['email']}}</label>
                            <br>
                            @if($u['email_verify_at']===null)
                            <label class="text-danger">Please check your email inbox to verify your email!</label>
                            @else
                            <label>Email has been verify!</label>
                            <br>
                            <a href="/auth/changeMail" class="btn btn-primary text-light mt-2">Change email</a>
                            @endif
                        </div>
                        <div class="form-group mt-2">
                            <label>Role: {{$u['role']}}</label>
                        </div>
                        <div class="form-group mt-2">
                            <label>Password: **********</label>
                            <br>
                            <a href="/auth/changepassword" class="btn btn-primary text-light mt-2">Change password</a>
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
    var old=document.querySelector('img.profile-img').src;
    formData.append('old', old);
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        url: '/auth/uploadImage/'+id,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            if(data.success){
                var images = document.querySelectorAll('img.profile-img');
                for (var i = 0; i < images.length; i++) {
                    images[i].src = '/images/user/' + data.img;
                }
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