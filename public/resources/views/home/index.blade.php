@extends('shared.layout')
@section('body')
@section('title','Home')
<!-- Main-body -->
            <!-- Hero Start -->
            <div class="container-fluid py-5 mb-5 hero-header">
                <div class="container py-5">
                    <div class="row g-5 align-items-center">
                        <div class="col-md-12 col-lg-7">
                            <h4 class="mb-2 text-secondary" style="text-shadow: 1px 1px 5px black;">What drink today?</h4>
                            <h1 class="mb-4 display-3 text-primary" style="text-shadow: 1px 1px 5px black;">Coffee & fruit tea</h1>
                            <p class="text-primary fw-bold" style="text-shadow: 1px 1px 5px black;">Whether you're looking for a creative <br> coffee to start your day, a delicious cup <br> of tea to relax after a long day, or a <br> refreshing freeze, make your choice!</p>
                        </div>
                        <div class="col-md-12 col-lg-5">
                            <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active rounded">
                                        <img src="/images/page/next-1.webp" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    </div>
                                    <div class="carousel-item rounded">
                                        <img src="/images/page/next-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    </div>
                                    <div class="carousel-item rounded">
                                        <img src="/images/page/next-3.webp" class="img-fluid w-100 h-100 rounded" alt="Three slide">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Hero End -->


            <!-- Featurs Section Start -->
            <div class="container-fluid featurs py-5">
                <div class="container py-5">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="featurs-item text-center rounded bg-light p-4">
                                <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                    <i class="fas fa-car-side fa-3x text-white"></i>
                                </div>
                                <div class="featurs-content text-center">
                                    <h5>Free Shipping</h5>
                                    <p class="mb-0">Free on order over $300</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="featurs-item text-center rounded bg-light p-4">
                                <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                    <i class="fas fa-user-shield fa-3x text-white"></i>
                                </div>
                                <div class="featurs-content text-center">
                                    <h5>Security Payment</h5>
                                    <p class="mb-0">100% security payment</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="featurs-item text-center rounded bg-light p-4">
                                <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                    <i class="fas fa-exchange-alt fa-3x text-white"></i>
                                </div>
                                <div class="featurs-content text-center">
                                    <h5>30 Day Return</h5>
                                    <p class="mb-0">30 day money guarantee</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="featurs-item text-center rounded bg-light p-4">
                                <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                    <i class="fa fa-phone-alt fa-3x text-white"></i>
                                </div>
                                <div class="featurs-content text-center">
                                    <h5>24/7 Support</h5>
                                    <p class="mb-0">Support every time fast</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Featurs Section End -->

            <!-- Vesitable Shop Start-->
            <div class="container-fluid vesitable py-5">
                <div class="container py-5">
                    <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                        <h1 class="display-4 text-light">Bestseller Products</h1>
                        <p>Are the preferred products with the most successful orders at the website.</p>
                    </div>
                    <div class="owl-carousel vegetable-carousel justify-content-center">
                        @foreach($recommend as $v)
                            <div class="border border-primary rounded position-relative vesitable-item">
                                <div class="vesitable-img">
                                    <img src="/images/product/{{$v['ImageUrl']}}" class="img-fluid w-100 rounded-top" alt="">
                                </div>
                                <!-- <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div> -->
                                <div class="p-4 rounded-bottom">
                                    <h4 class="text-truncate text-light">{{$v['ProductName']}}</h4>
                                    @if($v['Description']==null)
                                        <p class="text-truncate">Sản phẩm độc đáo, ngon miệng, giá cả phải chăng, đảm bảo chất lượng và an toàn vệ sinh thực phẩm.</p>
                                    @else
                                    <p class="text-truncate">{!! htmlspecialchars_decode($v['Description'])!!}</p>
                                    @endif
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <!-- <p class="text-dark fs-5 fw-bold mb-0">$4.99 / kg</p> -->
                                        <a href="/product/details/{{$v['ProductId']}}" class="btn btn-light border border-secondary rounded-pill px-3 text-dark"><i class="fa fa-shopping-bag me-2 text-danger"></i>See more</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Vesitable Shop End -->

            <!-- Fruits Shop Start-->
            <div class="container-fluid fruite py-5">
                <div class="container py-5">
                    <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                        <h1 class="display-4 text-light">Beverage products</h1>
                        <p>All of our beverage products are carefully selected and made from the finest ingredients, ensuring you the best drinking experience. Enjoy and enjoy the great taste of our beverage products!</p>
                    </div>
                    <div class="tab-class">
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 style="color: rgba(255, 255, 255, .5);">Categories</h4>

                                            <ul class="list-unstyled fruite-categorie">
                                                <li id="no-cat-li" class="btn btn-changes d-block active">
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a><i class="fas fa-meteor me-3"></i>All products</a>
                                                    </div>
                                                </li>
                                                @foreach($arr as $v)
                                                <li id="{{$v['CategoryId']}}" class="btn btn-changes d-block">
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a><i class="fas fa-meteor me-3"></i>{{$v['CategoryName']}}</a>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div id="tablebody" class="row g-4 justify-content-center">
                                    
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>
            <!-- Fruits Shop End-->


            


            <!-- Fact Start -->
            <div class="container-fluid py-5">
                <div class="container">
                    <div class="bg-light p-5 rounded">
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="counter bg-white rounded p-5">
                                    <i class="fa fa-users text-secondary"></i>
                                    <h4>satisfied customers</h4>
                                    <h1>1963</h1>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="counter bg-white rounded p-5">
                                    <i class="fa fa-users text-secondary"></i>
                                    <h4>quality of service</h4>
                                    <h1>99%</h1>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="counter bg-white rounded p-5">
                                    <i class="fa fa-users text-secondary"></i>
                                    <h4>quality certificates</h4>
                                    <h1>33</h1>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-3">
                                <div class="counter bg-white rounded p-5">
                                    <i class="fa fa-users text-secondary"></i>
                                    <h4>Available Products</h4>
                                    <h1>789</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fact Start -->
        <!-- Main-body end -->
@section('scripts')
<script>
$(document).ready(function(){
    $('.list-group-item').on('click', function() {
        $('.list-group-item.active').removeClass('active');
        if($(this).attr('name')!=null)
            $('li[id='+$(this).attr('name')+']').addClass('active');
        else{
            $(this).addClass('active');
            
        }
    });
    $('.btn-changes').on('click', function() {
        $('.btn-changes.active').removeClass('active');
        if($(this).attr('name')!=null)
            $('li[id='+$(this).attr('name')+']').addClass('active');
        else{
            $(this).addClass('active');
            
        }
    });
});
function getProductIndex(event, $page){
    event.preventDefault();
    var htmlbd=``;
    var urla='/home/getProductIndex?page='+$page;
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        url: urla,
        type: 'POST',
        data: {
            _token: '{{csrf_token()}}'
        },
        success: function(response) {
          if(response.success) {
              
              $.each(response.product, function(i, v) {
                v['Description']=htmlDecode(v['Description']);
                if(v['Description'] == 'null')
                    v['Description']='Sản phẩm độc đáo, ngon miệng, giá cả phải chăng, đảm bảo chất lượng và an toàn vệ sinh thực phẩm.';
                else if(v['Description'].length>100)
                    v['Description']=v['Description'].substring(0,100)+'...';
              htmlbd+=`<div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="rounded border border-secondary position-relative fruite-item">
                                <div class="fruite-img">
                                    <img src="/images/product/${v['ImageUrl']}" class="img-fluid w-100 rounded-top" alt="">
                                </div>
                                <div class="p-4">
                                    <h4 class="text-light">${v['ProductName']}</h4>
                                    <p>${v['Description']}</p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <a href="/product/details/${v['ProductId']}" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-dark"></i>See more</a>
                                    </div>
                                </div>
                        </div>
                        </div>`;
              });
              htmlbd += `<nav class="mt-2" aria-label="Page navigation">
                          <ul class="pagination d-flex justify-content-center mt-5" id="pagination">
                          </ul>
                        </nav>`;
              document.getElementById('tablebody').innerHTML = htmlbd;
              var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a type="button" class="page-link rounded me-2" href="#" onclick="getProductIndex(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a type="button" class="page-link rounded me-2" href="#" onclick="getProductIndex(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a type="button" class="page-link rounded me-2" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a type="button" class="page-link rounded me-2" href="#" onclick="getProductIndex(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a type="button" class="page-link rounded" href="#" onclick="getProductIndex(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link rounded" href="#" onclick="getProductIndex(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              document.getElementById('pagination').innerHTML = pagination;
          } else {
              htmlbd = `<tr><td>${response.msg}</td></tr>`;
              document.getElementById('tablebody').innerHTML = htmlbd;
          }
        },
        error: function(error) {
            console.log(error);
        }
    });
    
  }

  
  window.addEventListener('load', (event) => {
    var urlParams = new URLSearchParams(window.location.search);
    if(urlParams.has('category')){
        var category = urlParams.get('category');
        $('.list-group-item.active').removeClass('active');
        $('.btn-changes.active').removeClass('active');
        $('li[id='+category+']').addClass('active');
        getProductByClass(event, category, 1);
    }
    else
        getProductIndex(event, 1);
  });
  function htmlDecode(input){
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
};
document.getElementById('no-cat-li').addEventListener('click',function(e){
    getProductIndex(e, 1);
});
document.getElementById('no-cat').addEventListener('click',function(e){
    getProductIndex(e, 1);
});
let elements = document.getElementsByClassName('btn-changes');
for(let i = 0; i < elements.length; i++) {
    elements[i].addEventListener('click', function(e) {
        var $id=$(this).attr('id');
        if($id=='no-cat-li'||$id=='no-cat')
            getProductIndex(e, 1);
        else
            getProductByClass(e,$id,1);
    });
}
function getProductByClass(e,$id,$page){
    e.preventDefault();
        var classId=$id;
        var htmlbd=``;
        var urla='/home/getProductByClass?page='+$page;
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: urla,
            type: 'POST',
            data: {
                classId:classId,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
            if(response.success) {
                $.each(response.product, function(i, v) {
                    v['Description']=htmlDecode(v['Description']);
                    if(v['Description'] == 'null')
                    v['Description']='Sản phẩm độc đáo, ngon miệng, giá cả phải chăng, đảm bảo chất lượng và an toàn vệ sinh thực phẩm.';
                else if(v['Description'].length>100)
                    v['Description']=v['Description'].substring(0,100)+'...';
              htmlbd+=`<div class="col-md-6 col-lg-6 col-xl-4">
                            <div class="rounded border border-secondary position-relative fruite-item">
                                <div class="fruite-img">
                                    <img src="/images/product/${v['ImageUrl']}" class="img-fluid w-100 rounded-top" alt="">
                                </div>
                                <div class="p-4">
                                    <h4 class="text-light">${v['ProductName']}</h4>
                                    <p>${v['Description']}</p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <a href="/product/details/${v['ProductId']}" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i>See more</a>
                                    </div>
                                </div>
                        </div>
                        </div>`;
                });
                htmlbd += `<nav class="mt-2" aria-label="Page navigation">
                          <ul class="pagination d-flex justify-content-center mt-5" id="pagination">
                          </ul>
                        </nav>`;
                document.getElementById('tablebody').innerHTML = htmlbd;
                var currentPage = $page; // Trang hiện tại
                var lastPage = response.page; // Trang cuối cùng
                if(currentPage==1)
                    var pagination = '<li class="page-item disabled"><a class="page-link rounded me-2" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                else
                    var pagination = '<li class="page-item"><a class="page-link rounded me-2" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                for (var i = 1; i <= lastPage; i++) {
                    if (i == currentPage) {
                        // Nếu i là trang hiện tại, tạo một nút được chọn
                        pagination += '<li class="page-item active"><a class="page-link rounded me-2" href="#">' + i + '</a></li>';
                    } else {
                        // Nếu không, tạo một nút bình thường
                        pagination += '<li class="page-item"><a class="page-link rounded me-2" href="#" onclick="getProductByClass(event, '+$id+',' + i + ')">' + i + '</a></li>';
                    }
                }
                if(currentPage==lastPage)
                pagination += '<li class="page-item disabled"><a class="page-link rounded" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                else
                    pagination += '<li class="page-item"><a class="page-link rounded" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                document.getElementById('pagination').innerHTML = pagination;
            } else {
                htmlbd = `<tr><td>${response.msg}</td></tr>`;
                document.getElementById('tablebody').innerHTML = htmlbd;
            }
            },
            error: function(error) {
                console.log(error);
            }
        });
}

</script>

@endsection
@endsection

