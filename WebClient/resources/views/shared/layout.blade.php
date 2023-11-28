<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <link href="/css/style.min.css" rel="stylesheet" />
        <link href="/css/styles.css" rel="stylesheet" />
        <script src="/js/all.js" crossorigin="anonymous"></script>
        <script src="/js/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/all.min.css">
        <link rel="stylesheet" href="/css/jquery.dataTables.min.css">
        <link href="/css/dataTables.bootstrap5.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="/css/kendo.common.min.css" rel="stylesheet" />
        <link href="/css/kendo.bootstrap.min.css" rel="stylesheet" />
        <script src="/js/kendo.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
                <style>
            input::-webkit-search-clear-button {
        display: none;
            }
            .element {
                    margin-top: 8.5vh; 
                }
            @media (min-width: 1919px) {
                .element {
                    margin-top: 5.5vh; 
                }
            }
            /* Định dạng cho dropdown container */
            .dropdown-tools:hover .dropdown-menu-tools {
            display: block; 
            right: 0;
            }
            .button-pages a i {
                transition: all 0.3s ease;
            }

            .button-pages a:hover i {
                background-color: rgba(255, 255, 255, 0.25);
                border-radius: 10px;
                padding: 1vh 3vh;
                margin: -1vh -3vh;
            }
            .profile-container {
                width: 100px;
                height: 100px;
                padding: 10px;
                border: 0.2px solid cadetblue;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .profile-image {
                width: 100%;
                height: 100%;
                opacity: none;
                object-fit: cover;
                border-radius: 50%;
            }
            .profile-contai {
                width: 50px;
                height: 50px;
                padding: 2px;
                border: 0.2px solid cadetblue;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .profile-img {
                width: 100%;
                height: 100%;
                opacity: none;
                object-fit: cover;
                border-radius: 50%;
            }
            .image-container img {
                /* other styles */
                transition: none;
            }

            .image-container:hover img {
                filter: blur(2px);
                transition: filter 0.3s;
            }
            .image-container {
                position: relative;
                /* other styles */
            }

            .image-container .ip-img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
            }
            .image-container .ip-img {
                /* other styles */
                transition: none;
            }
            .image-container:hover .ip-img {
                position: fixed;
                opacity: 1;
                transition: filter 0.3s;
            }
            .dropdown-toggle-bell::after {
                display: none;
            }
        </style>
        @yield('style-btn')
    </head>
    <body class="sb-nav-fixed bg-dark"  style="font-family: cursive;">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark stylebg" style="top:0;">
            <!-- Navbar Brand-->
            <a class="ms-3 rounded-circle" href="/" style="background-image: url(/images/page/tenor.gif); background-size: cover; min-width: 2rem; min-height: 2rem;">
            </a>
            <a class="navbar-brand ps-3" href="/">Coffee shop</a>
            <!-- Sidebar Toggle-->
            <div class="ms-auto me-5 my-2 my-md-0 button-pages">
                <a class="text-light" href="/">
                    <i class="bi bi-house-door fa-lg"></i>
                </a>
            </div>
            <div class="ms-3 me-4 my-2 my-md-0 button-pages dropdown">
                <button class="text-light dropdown-toggle" style="background-color: transparent; border: none;" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-layout-wtf fa-lg"></i>
                </button>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @if(Session::has('category'))
                    <li class="list-group-item active border-0 pe-5 lyo" style="list-style-type: none; width: 100%;" id="no-cat" name="no-cat-li">
                        <a href="/" class="btn border-0 w-100 btn-changes">Tất cả</a>
                    </li>
                    @foreach(Session::get('category') as $v)
                    <li class="list-group-item border-0 pe-5 lyo" style="list-style-type: none;" name="{{$v['CategoryId']}}">
                        <a href="/?category={{$v['CategoryId']}}" class="btn border-0 w-100 btn-changes" id="{{$v['CategoryId']}}">{{$v['CategoryName']}}</a>
                    </li>
                    @endforeach
                @endif
                </ul>
            </div>
            @if(Session::has('token')||isset($_COOKIE['remember_token']))
            <div class="ms-3 me-5 my-2 my-md-0 button-pages dropdown" id="bell-notification">
                <button class="text-light dropdown-toggle dropdown-toggle-bell position-relative" id="dropdown-tg-bell" style="background-color: transparent; border: none;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fa-lg"></i>
                </button>
                <ul class="dropdown-menu overflow-auto" style="max-height: 200px;" aria-labelledby="dropdownMenuLink" id="notificationDropdown">
                </ul>
            </div>
            @endif
            <div class="ms-3 me-5 my-2 my-md-0 button-pages">
                <a class="text-light" href="/invoice" placeholder="Home">
                    <i class="bi bi-truck fa-lg"></i>
                </a>
            </div>
            <div class="ms-3 me-5 my-2 my-md-0 button-pages">
                <a class="text-light" href="/cart">
                    <i class="bi bi-cart3 fa-lg"></i>
                </a>
            </div>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-4 me-1 my-2 my-md-0">
                <div class="rounded-pill bg-dark border border-light stylebg" style="top:0;">
                    <div class="input-group">
                        <input id="searchBox" style="top:0;" type="text" placeholder="Search..." aria-describedby="button-addon1" class="form-control border-0 rounded-pill bg-0 text-light shadow-none stylebg" maxlength="32">
                        <ul id="dropdownSB" class="dropdown-menu mt-5 overflow-auto" aria-labelledby="tools" style="max-height: 200px;">
                        </ul>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-1 me-1">
                <li class="nav-item dropdown dropdown-tools">
                    <a class="nav-link text-light pe-none" id="user" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle fa-lg"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-tools" aria-labelledby="navbarDropdown">
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
                        }
                        @endphp
                        @if(isset($user))
                        <div class="form-group d-flex justify-content-center">
                            <div class="profile-contai rounded-circle">
                                <img class="profile-img" src="/images/user/{{$user['img']}}" alt="Profile Image">
                            </div>
                        </div>
                        <li><a class="dropdown-item" id="id-log" name="{{$user['id']}}" href="/auth">{{$user['name']}}</a></li>
                        <li><a class="dropdown-item" href="/auth/logout">Logout</a></li>
                        @endif
                    @else
                        <li><a class="dropdown-item" href="/auth/login">Login</a></li>
                        <li><a class="dropdown-item" href="/auth/register">Register</a></li>
                    @endif
                        <li>
                            <div class="form-check form-switch d-flex pe-none align-items-center justify-content-left m-0 p-0" style="width: 17vh;"> 
                                <label class="d-inline dropdown-item form-check-label labelbg">Dark</label>
                                <input class="d-inline pe-auto dropdown-item form-check-input bg-warning" type="checkbox" id="flexSwitchCheckDefault"> 
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            @if (Session::has('token')||isset($_COOKIE['remember_token']))
                @php
                $token = Session::has('token') ? Session::get('token') : $_COOKIE['remember_token'];
                $response=Http::withToken($token)->get('http://127.0.0.1:8000/api/auth')->json();
                if(isset($response['user'])){
                    $user=$response['user'];
                }
                @endphp
                @if(isset($user) && $user['role']==1)
                    <ul class="navbar-nav me-3" id="admin">
                        <li class="nav-item dropdown dropdown-tools">
                            <a class="nav-link text-light pe-none" id="tools" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-tools" aria-labelledby="tools">
                                <li><label class="dropdown-item pe-none opacity-75" style="font-size: 1.5vh; ">AUTHENTICATOR</label></li>
                                <li><a class="dropdown-item" href="/role">Role</a></li>
                                <li><a class="dropdown-item" href="/user">User</a></li>
                                <li><label class="dropdown-item pe-none opacity-75" style="font-size: 1.5vh; ">PRODUCTS</label></li>
                                <li><a class="dropdown-item" href="/product">Product</a></li>
                                <li><a class="dropdown-item" href="/category">Category</a></li>
                                <li><label class="dropdown-item pe-none opacity-75" style="font-size: 1.5vh; ">TRANPOST</label></li>
                                <li><a class="dropdown-item" href="/invoice/admins">Invoice</a></li>
                                <li><a class="dropdown-item" href="/invoice/revenue">Revenue</a></li>
                            </ul>
                        </li>
                    </ul>
                @endif
            @endif
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_content" class="px-0 mx-auto" name="stylebg" style="overflow-x: auto;">
                <main>
                    <div class="container-fluid px-4">
                        @yield('body')
                    </div>
                </main>
                <footer class="py-4 mt-auto stylebg" style="bottom:0;">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small text-light opacity-75">
                            <div class=" text-decoration-underline">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a class="text-warning" href="#">Privacy Policy</a>
                                &middot;
                                <a class="text-warning" href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            
        </div>
        <script src="/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="/js/scripts.js"></script>
        <script src="/js/jquery.dataTables.min.js"></script>
        <script src="/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
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
            var bellNotification = document.getElementById('bell-notification');
            if (bellNotification) {
                bellNotification.addEventListener('click', function() {
                    $.ajax({
                        url: '/message/activeMessage',
                        type: 'POST',
                        data: {
                            _token: '{{csrf_token()}}'
                        },
                        success: function(response) {
                            if(response.success) {
                                document.getElementById('dropdown-tg-bell').innerHTML = `<i class="bi bi-bell fa-lg"></i>`;
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            }

            document.getElementById('flexSwitchCheckDefault').addEventListener('change', function() {
                var elements = document.getElementsByClassName('stylebg');
                var labels = document.getElementsByClassName('labelbg');
                var bodys = document.getElementsByName('stylebg');
                for (var i = 0; i < elements.length; i++) {
                    if (this.checked) {
                        changes(elements[i],'url(/images/auth/pagesea.jpg) no-repeat fixed');
                        changes(bodys[0],'url(/images/auth/pagesea.jpg) no-repeat fixed');
                        labels[0].textContent = 'Light';
                        localStorage.setItem('checkboxStatus', 'checked');
                    } else {
                        changes(elements[i],'url(/images/page/nightstar.jpg) no-repeat fixed');
                        changes(bodys[0],'url(/images/page/nightstar.jpg) no-repeat fixed');
                        labels[0].textContent = 'Dark';
                        localStorage.setItem('checkboxStatus', 'unchecked');
                    }
                }
            });

            window.addEventListener('DOMContentLoaded', (event) => {
                var checkbox = document.getElementById('flexSwitchCheckDefault');
                if (checkbox) {
                    var checkboxStatus = localStorage.getItem('checkboxStatus');
                    if (checkboxStatus === 'checked') {
                        checkbox.checked = true;
                    } else {
                        checkbox.checked = false;
                    }
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
            $(document).ready(function() {
                $('#searchBox').on('input', function() {
                    var searchQuery = $(this).val();
                    if (searchQuery.length > 0 && searchQuery.trim() != '') {
                        $.ajax({
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
            
            function getMessageUser(){
                
                $.ajax({
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
                        htmlbd += `<li class="list-group-item active border-0 lyo" style="list-style-type: none; width: 100%;">
                        <a class="dropdown-item d-flex align-items-center">
                <div class="font-weight-bold">
                    <div class="text-truncate">${v.content}</div>
                    
                    <div class="small text-gray-500">Time: ${v.time}, Date: ${v.date}</div>
                </div>
            </a>
                    </li>
                            `;
                    });
                    if(demmessage!=0){
                        document.getElementById('dropdown-tg-bell').innerHTML = `<i class="bi bi-bell-fill fa-lg"></i>
                    <span class="position-absolute span-spell top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        `+demmessage+`<span class="visually-hidden">New alerts</span>
                    </span>`;
                    }
                    document.getElementById('notificationDropdown').innerHTML = htmlbd;
                    
                } else {
                    htmlbd = `<li class="list-group-item active border-0 pe-5 lyo" style="list-style-type: none; width: 100%;">
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

