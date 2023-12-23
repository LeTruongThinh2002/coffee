<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="/images/page/tenor.ico">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    @yield('title')
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="/admin/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/admin/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="/admin/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
  <script src="/js/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
  <link href="/css/kendo.common.min.css" rel="stylesheet" />
  <link href="/css/kendo.bootstrap.min.css" rel="stylesheet" />
  <script src="/js/kendo.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
  <link rel="stylesheet" href="/css/jquery.dataTables.min.css">
  <style type="text/css">
    @keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.material-icons-setting {
  animation: spin 2s linear infinite;
}
.material-icons-setting-chart {
  animation: spin 2s linear;
}


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
@media (max-width: 991px) {
    .dark-version span{
    color: black !important;
  }
    
  }
  .k-tool-group{ 
    span {
    color: black !important;
  }
}
  </style>
  @yield('style')
</head>

<body class="g-sidenav-show  bg-gray-200 dark-version">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0">
        <img src="/images/page/tenor.gif" class="navbar-brand-img h-100 rounded-circle me-2" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">CoffeeShop Admin</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white Revenue" href="/invoice/revenue">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="bi bi-clipboard2-data-fill"></i>
            </div>
            <span class="nav-link-text ms-1">Revenue</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white Invoice" href="/invoice/admins">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-receipt-cutoff"></i>
            </div>
            <span class="nav-link-text ms-1">Invoice</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white Product" href="/product">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-cup-straw"></i>
            </div>
            <span class="nav-link-text ms-1">Product</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white Role" href="/role">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-person-video3"></i>
            </div>
            <span class="nav-link-text ms-1">Role</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white User" href="/user">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-person-lines-fill"></i>
            </div>
            <span class="nav-link-text ms-1">User</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white Category" href="/category">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="bi bi-boxes"></i>
            </div>
            <span class="nav-link-text ms-1">Category</span>
          </a>
        </li>
      </ul>
    </div>
    
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Requires admin rights to fully use the management function!</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="/auth" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user fa-2x me-sm-1"></i>
              </a>
            </li>
            
            <li class="nav-item ps-3 d-flex align-items-center">
              <a href="/" class="nav-link text-body p-0">
                <i class="fa fa-home fa-2x fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item d-xl-none px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
  @yield('body')
  </main>
  
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons material-icons-setting py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" checked="true" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="/admin/assets/js/core/popper.min.js"></script>
  <script src="/admin/assets/js/core/bootstrap.min.js"></script>
  <script src="/admin/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="/admin/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="/admin/assets/js/plugins/chartjs.min.js"></script>
  <script src="/js/jquery.dataTables.min.js"></script>
  <script src="/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
  @yield('scripts')
  <script>
    $(window).on('load', function() {
      $('a').removeClass('active');
    $('.' + document.title).addClass('active');
});
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="/admin/assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>

</html>