<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>@yield('title')</title>
        <link rel="icon" type="image/x-icon" href="/images/page/tenor.ico">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- Libraries Stylesheet -->
        <link href="/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <script src="/js/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/jquery.dataTables.min.css">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/kendo.common.min.css" rel="stylesheet" />
        <link href="/css/kendo.bootstrap.min.css" rel="stylesheet" />
        <script src="/js/kendo.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
        <style>
            .modal {
  /* Đặt modal ở giữa màn hình */
  /* position: fixed;
   */
  max-width: fit-content;
  max-height: fit-content;
   @media (min-width: 900px) {
    top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  max-height: 80vh; 
  max-width: 80vh;
    }
   
}

        </style>
        
    </head>

    <body @yield('class-body') style="background-image: url(/images/page/2.png); color: rgba(255, 255, 255, .8); background-size: cover;">

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar d-none d-lg-block" style="background-image: url(/images/page/pixel-night.gif); background-size: auto; min-width: 2rem; min-height: 2rem; background-position: top;">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> 
                            <a target="_blank" href="https://github.com/LeTruongThinh2002" class="fw-bold  text-white" style="text-shadow: black 2px 1px 5px;">Created by Le Truong Thinh</a></small>
                        <small class="me-3">
                            <i class="fas fa-envelope me-2 text-secondary"></i>
                            <a target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=LTruongThinh2002@gmail.com&body=&subject=" class="fw-bold  text-white" style="text-shadow: black 2px 1px 5px;">LTruongThinh2002@gmail.com</a>
                        </small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="https://github.com/LeTruongThinh2002/coffee" class="fw-bold" style="text-shadow: black 2px 1px 5px;"><small class="text-white ms-2">Access the source code at github</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light navbar-expand-xl" style="background-color:#370202;">
                    <a href="/" class="navbar-brand"><h2 class="text-primary display-6 animation-title" style="text-shadow: black 2px 1px 5px;">CoffeeShop</h2></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse" style="background-color:#370202;" id="navbarCollapse">
                        <div class="navbar-nav mx-auto" id="div-dropdown">
                            <a href="/" class="nav-item nav-link">Home</a>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Category</a>
                                <ul class="dropdown-menu m-0 bg-white p-0 rounded-0">
                                    @if(Session::has('category'))
                                        <li id="no-cat" name="no-cat-li" class=" text-center dropdown-item list-group-item"><a class="btn-changes" style="color: black !important;" href="/">All products</a></li>
                                        @foreach(Session::get('category') as $v)
                                            <li class="dropdown-item text-center list-group-item" name="{{$v['CategoryId']}}"><a style="color: black !important;" href="/?category={{$v['CategoryId']}}" id="{{$v['CategoryId']}}" class="btn-changes">{{$v['CategoryName']}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            
                            <a href="/cart" class="nav-item nav-link">Cart</a>
                            
                            <a href="/invoice" class="nav-item nav-link">Invoice</a>
                        </div>
                        <div id="div-icon" class="d-flex m-3 me-0">
                                <a id="search-box" class="nav-item nav-link btn border border-secondary btn-md-square rounded-circle bg-white me-2" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <i class="fas fa-search fa-lg text-primary"></i>
                                </a>
                                @if (Session::has('token')||isset($_COOKIE['remember_token']))
                                    @php
                                        $token = Session::has('token') ? Session::get('token') : $_COOKIE['remember_token'];
                                        $response=Http::withToken($token)->get('http://127.0.0.1:8000/api/auth')->json();
                                        if(isset($response['user'])){
                                            $user=$response['user'];
                                            $img=$response['img'];
                                            foreach($img as $v){
                                                if($user['id']==$v['UserId'])
                                                    $user['img']=$v['ImageUrl'];
                                            }
                                            if(!isset($user['img']))
                                                $user['img']='none.jpg';
                                        }else{
                                            Session::forgot('token');
                                            setcookie('remember_token', '', time() - 3600);
                                        }
                                    @endphp
                                    @if(isset($user))
                                            <div class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle dropdown-toggle-bell" id="dropdown-tg-bell" data-bs-toggle="dropdown">
                                                    <i class="far fa-bell fa-2x"></i>
                                                </a>
                                                <ul class="bg-white p-0 dropdown-menu dropdown-menu-start overflow-auto" style="max-height: 50vh;" aria-labelledby="dropdownMenuLink" id="notificationDropdown">
                                                </ul>
                                            </div>
                                            <div class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle dropdown-toggle-bell" id="dropdown-tg-bell" data-bs-toggle="dropdown">
                                                    <i class="fas fa-user fa-2x"></i>
                                                </a>
                                                <ul class="bg-white p-0 dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuLink" id="notificationDropdown">
                                                    <li class="dropdown-item list-group-item border-0" style="list-style-type: none; width: 100%; background-color: transparent;">
                                                        <a class="d-flex align-items-center justify-content-center">
                                                            <div class="profile-contai rounded-circle">
                                                                <img src="/images/user/{{$user['img']}}" alt="" class="profile-img">
                                                            </div>
                                                        </a>
                                                    </li>
                                                    <li class="dropdown-item list-group-item border-0" style="list-style-type: none; width: 100%;">
                                                        <a href="/auth" class="d-flex align-items-center justify-content-center text-dark">
                                                            {{$user['name']}}
                                                        </a>
                                                    </li>
                                                    <li class="dropdown-item list-group-item border-0" style="list-style-type: none; width: 100%;">
                                                        <a href="/auth/logout" class="d-flex align-items-center justify-content-center text-dark">
                                                            Logout
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <a class="nav-item nav-link" href="/invoice/revenue">
                                            <i class="fas fa-cog fa-2x"></i>
                                        </a>
                                    @else
                                    <a href="/auth/login" class="nav-link nav-item">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>    
                                    @endif
                                @else
                                    <a href="/auth/login" class="nav-link nav-item">
                                        <i class="fas fa-user fa-2x"></i>
                                    </a>
                                @endif
                            </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-start">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input id="searchBox" type="search" class="form-control p-3" placeholder="Products name..." aria-describedby="search-icon-1">
                            <ul id="dropdownSB" class="dropdown-menu mt-5 overflow-auto" aria-labelledby="tools" style="max-height: 50vh;">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->
        @yield('body')
        
        <!-- Footer Start -->
        <div class="container-fluid text-white-50 footer pt-5 mt-5" style="background-color: #370202;">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h1 class="text-primary mb-0">CoffeeShop</h1>
                                <p class="text-secondary mb-0">Drink products</p>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative mx-auto">
                                <input id="email-contact" class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="email" placeholder="Your Email">
                                    <a  class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;" id="contact-link" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&from=&to=LTruongThinh2002@gmail.com&body=&subject=">Contact Now</a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" target="_blank" href="http:\\www.github.com\LeTruongThinh2002"><i class="fab fa-github"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="https://line.me/ti/p/5X8JR_sNbx" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href="https://www.facebook.com/le.truong.thinh.2002" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href="https://maps.app.goo.gl/ts7e9bTidLZMtcoU7" target="_blank"><i class="bi bi-geo-alt-fill"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Shop Info</h4>
                            <a class="btn-link" href="http:\\www.github.com\LeTruongThinh2002">About Us</a>
                            <a class="btn-link" href="http:\\www.github.com\LeTruongThinh2002">Contact Us</a>
                            <a class="btn-link" href="http:\\www.github.com\LeTruongThinh2002">Privacy Policy</a>
                            <a class="btn-link" href="http:\\www.github.com\LeTruongThinh2002">Terms & Condition</a>
                            <a class="btn-link" href="http:\\www.github.com\LeTruongThinh2002">Return Policy</a>
                            <a class="btn-link" href="http:\\www.github.com\LeTruongThinh2002">FAQs & Help</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Account</h4>
                            <a class="btn-link" href="/auth">My Account</a>
                            <a class="btn-link" href="/">Shop details</a>
                            <a class="btn-link" href="/cart">Shopping Cart</a>
                            <a class="btn-link" href="/cart">Wishlist</a>
                            <a class="btn-link" href="/invoice">Order History</a>
                            <a class="btn-link" href="/invoice">International Orders</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address: 15/102A/20 Hoa Binh, p.3, Q.11</p>
                            <p>Email: LTruongThinh@gmail.com</p>
                            <p>Phone: +84783 280 183</p>
                            <p>Payment Accepted</p>
                            <img src="/images/page/payment.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    
    <script src="/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/lib/easing/easing.min.js"></script>
    <script src="/lib/waypoints/waypoints.min.js"></script>
    <script src="/lib/lightbox/js/lightbox.min.js"></script>
    <script src="/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="/js/scripts.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- Template Javascript -->
    <script src="/js/main.js"></script>
    <script>

        var checkBells=document.getElementById('dropdown-tg-bell');
            if(checkBells)
            {Pusher.logToConsole = false;

            var pusher = new Pusher('372e43b5e71965f3a5f9', {
                encrypted:true,
            cluster: 'ap1'
            });

            var channel = pusher.subscribe('Message');
            channel.bind('App\\Events\\GetMgsRealTime', function(data) {
                getMessageUser();
            });}

            function changes(items, text){
                items.style.background = text;
                items.style.backgroundSize = 'cover';
            }
            var bellNotification = document.getElementById('dropdown-tg-bell');
            if (bellNotification) {
                bellNotification.addEventListener('mouseenter', function() {
                    $.ajax({
                        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
                        url: '/message/activeMessage',
                        type: 'POST',
                        data: {
                            _token: '{{csrf_token()}}'
                        },
                        success: function(response) {
                            if(response.success) {
                                document.getElementById('dropdown-tg-bell').innerHTML = `<i class="far fa-bell fa-2x"></i>`;
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            }
            $(document).ready(function() {
                $('#searchBox').on('input', function() {
                    var searchQuery = $(this).val();
                    if (searchQuery.length > 0 && searchQuery.trim() != '') {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '/product/searchBox',
                            type: 'POST',
                            data: {
                                'q': searchQuery,
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if(data.success){
                                    var dropdown = $('#dropdownSB');
                                    dropdown.empty(); // Xóa các mục cũ
                                    data.dataSB.forEach(function(item) {
                                        var li = $('<li>');
                                        var link1 = $('<a>').attr('href', '/product/details/' + item.ProductId);
                                        var img = $('<img>').attr('src', '/images/product/' + item.ImageUrl)
                                                            .attr('alt', item.ProductName)
                                                            .addClass('border border-light rounded')
                                                            .css('width', '50');
                                        link1.append(img);
                                        li.append(link1);
                                        li.append('<br>');
                                        var link2 = $('<a>').attr('href', '/product/details/' + item.ProductId)
                                                            .addClass('text-decoration-none text-dark ')
                                                            .text(item.ProductName);
                                        li.append(link2);
                                        li.addClass('d-flex m-2 table-hover');
                                        dropdown.append(li);
                                    });
                                    dropdown.show(); // Hiển thị danh sách thả xuống
                                }else{
                                    var dropdown = $('#dropdownSB');
                                    dropdown.empty();
                                    dropdown.hide();
                                }
                            }

                        });
                    }else{
                        var dropdown = $('#dropdownSB');
                        dropdown.empty();
                        dropdown.hide();
                    }
                });
            });
    document.getElementById('email-contact').addEventListener('input', function (e) {
        var email = e.target.value;
        var link = document.getElementById('contact-link');
        link.href = "https://mail.google.com/mail/u/0/?view=cm&fs=1&from=" + encodeURIComponent(email) + "&to=LTruongThinh2002@gmail.com&body=&subject=";
    });
    
function getMessageUser(){
                
                $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/message/getMessageUser',
                type: 'POST',
                data: {
                    _token: '{{csrf_token()}}'
                },
                success: function(response) {
                if(response.success) {
                    var htmlbd = ``;
                    var demmessage=0;
                    $.each(response.msg, function(i, v) {
                        if(v.active!=1){
                            demmessage+=1;
                        }
                        htmlbd += `<li class="dropdown-item list-group-item border-0" style="list-style-type: none; width: 100%;">
                        <a class="d-flex align-items-center">
                <div class="font-weight-bold">
                    <div style="color: black !important;" style="color: black !important;" class="text-truncate">${v.content}</div>
                    
                    <div style="color: black !important;" class="small text-gray-500">Time: ${v.time}, Date: ${v.date}</div>
                </div>
            </a>
                    </li>
                            `;
                    });
                    if(demmessage!=0){
                        document.getElementById('dropdown-tg-bell').innerHTML = `<i class="fas fa-bell fa-2x"></i>
                    <span class="position-absolute span-spell translate-middle badge rounded-pill bg-danger">
                        `+demmessage+`<span class="visually-hidden">New alerts</span>
                    </span>`;
                    }
                    document.getElementById('notificationDropdown').innerHTML = htmlbd;
                    
                } else {
                    htmlbd = `<li class="list-group-item active border-0" style="list-style-type: none; width: 100%;">
                        <a class="btn border-0 w-100 btn-changes">${response.msg}</a>
                    </li>`;
                    document.getElementById('notificationDropdown').innerHTML = htmlbd;
                }
                },
                error: function(error) {
                    console.log(error);
                }
            });
            
            }
            window.addEventListener('load', (event) => {
                var retBell=document.getElementById('dropdown-tg-bell'); 
                if(retBell)
                    getMessageUser();
            });
    </script>
    @yield('scripts')
    </body>

</html>