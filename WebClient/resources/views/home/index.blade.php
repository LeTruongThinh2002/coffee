@extends('shared.layout')
@section('body')
@section('title','Home')
<div class="d-flex me-1 ps-1 pe-1 justify-content-center" style="overflow-x: visible; width: 100%; height: fit-content;">
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel" style="border-style: solid; border-color: whitesmoke; width: 100%; height: fit-content;">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="5000" >
            <img src="/images/page/next-1.webp" class="d-inline" alt="..." style="width: 100%; height: 250px;">
            </div>
            <div class="carousel-item" data-bs-interval="5000">
            <img src="/images/page/next-2.jpg" class="d-inline" alt="..." style="width: 100%; height: 250px;">
            </div>
            <div class="carousel-item" data-bs-interval="5000">
            <img src="/images/page/next-3.jpg" class="d-inline" alt="..." style="width: 100%; height: 250px;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="d-inline ms-3" style="border-style: solid; border-color: whitesmoke;">
        <img src="/images/page/coffee.webp" class="d-inline" alt="..."  style="width: 100%; height: 250px;">
    </div>
</div>
<div style="display: flex; align-items: center;">
  <h4 class="fw-bold text-light mt-2 mb-3 p-0">Recommend</h4>
  <hr class="text-light" style="flex-grow: 1; margin-left: 10px;">
</div>
<div class="d-flex button-re" style="overflow-x: visible;">
            @foreach($recommend as $v)
            <div class="d-inline me-3 p-2 ps-1 pe-1 text-center rounded-2 changes" style="width: 20vh;">
                <a href="/product/details/{{$v['ProductId']}}">
                    <img class="border border-light rounded" src="/images/product/{{$v['ImageUrl']}}" alt="{{$v['ProductName']}}" width="80%">
                </a>
                <br>
                <a href="/product/details/{{$v['ProductId']}}" class="text-decoration-none text-light">{{$v['ProductName']}}</a>
            </div>
            @endforeach
</div>
<div style="display: flex; align-items: center;">
  <h4 class="fw-bold text-light mt-2 mb-3 p-0">Category
  </h4>
  <hr class="text-light" style="flex-grow: 1; margin-left: 10px;">
</div>

<div class="d-flex text-light mb-3 border border-light border-top-0 ps-3 pb-3" style="width: 100%;">
    <div class="" style="width: max-content;">
            <li class="list-group-item active border-0 pe-5" style="list-style-type: none; width: 100%;" id="no-cat-li">
                <a class="btn border-0 text-light w-100">Tất cả</a>
            </li>
            @foreach($arr as $v)
            <li class="list-group-item border-0 pe-5 btn-changes" style="list-style-type: none;" id="{{$v['CategoryId']}}">
                <a class="btn border-0 text-light w-100">{{$v['CategoryName']}}</a>
            </li>
            @endforeach
    </div>
    <div id="tablebody" class="d-flex row button-re ms-3 justify-content-center border-start border-light ctn-changes" style="overflow-x: visible; max-width: fit-content;">    
    
</div>

</div>

@section('style-btn')
<style>
    .button-re .changes {
                transition: all 0.6s ease;
            }

            .button-re .changes:hover {
                background-color: rgba(255, 255, 255, 0.25);
                box-shadow: 0 0 8px 0 rgba(255, 255, 255, 0.2), 0 0 20px 0 rgba(255, 255, 255, 0.2);

            }
            .list-group-item {
                background-color: rgba(255, 255, 255, 0);
            }
</style>
@section('scripts')
<script>
$(document).ready(function(){
    ac('.list-group-item.active');
    $('.list-group-item').on('click', function() {
        notac('.list-group-item.active');
        $('.list-group-item.active').removeClass('active');
        if($(this).attr('name')!=null)
            $('li[id='+$(this).attr('name')+']').addClass('active');
        else{
            $(this).addClass('active');
            
        }
        ac('.list-group-item.active');
    });
});
function ac($a){
    $($a).css({"background-color": "rgba(255, 255, 255, 0.25)", "box-shadow": "0 0 8px 0 rgba(255, 255, 255, 0.2), 0 0 20px 0 rgba(255, 255, 255, 0.2)"});
}
function notac($b){
    $($b).css({"background-color": "rgba(255, 255, 255, 0)", "box-shadow": "none"});
}
function getProductIndex(event, $page){
    event.preventDefault();
    var htmlbd;
    var urla='/home/getProductIndex?page='+$page;
    $.ajax({
        url: urla,
        type: 'POST',
        data: {
            _token: '{{csrf_token()}}'
        },
        success: function(response) {
          if(response.success) {
              htmlbd = `<nav class="mt-2" aria-label="Page navigation example">
                          <ul class="pagination" id="pagination">
                          </ul>
                        </nav>`;
              $.each(response.product, function(i, v) {
                htmlbd += `
                    <div class="d-flex flex-row me-3 p-2 text-center rounded-2 changes" style="width: 55vh;">
                        <div>
                            <a href="/product/details/${v['ProductId']}">
                                <img class="border border-light rounded" src="/images/product/${v['ImageUrl']}" alt="${v['ProductName']}" width="100%">
                            </a>
                        </div>
                        <div style="width: 200vh;">    
                            <a href="/product/details/${v['ProductId']}" class="text-decoration-none text-light">${v['ProductName']}</a>
                            `;
                    if(v['Sizes'] && v['Prices']){
                        v['Sizes'].forEach(function(size, index) {
                            htmlbd += `
                            <div>
                                <span>Size: ${size} - ${v['Prices'][index]}</span>
                            </div>
                            `;
                        });
                    }
                    htmlbd += `</div></div>`;
              });
              document.getElementById('tablebody').innerHTML = htmlbd;
              var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a class="page-link" href="#" onclick="getProductIndex(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" href="#" onclick="getProductIndex(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getProductIndex(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" href="#" onclick="getProductIndex(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getProductIndex(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
        notac('.list-group-item.active');
        $('.list-group-item.active').removeClass('active');
        $('li[id='+category+']').addClass('active');
        ac('.list-group-item.active');
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
        getProductByClass(e,$id,1);
    });
}
function getProductByClass(e,$id,$page){
    e.preventDefault();
        var classId=$id;
        var htmlbd;
        var urla='/home/getProductByClass?page='+$page;
        $.ajax({
            url: urla,
            type: 'POST',
            data: {
                classId:classId,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
            if(response.success) {
                htmlbd = `<nav class="mt-2" aria-label="Page navigation example">
                            <ul class="pagination" id="pagination">
                            </ul>
                            </nav>`;
                $.each(response.product, function(i, v) {
                    htmlbd += `
                        <div class="d-flex flex-row me-3 p-2 text-center rounded-2 changes" style="width: 55vh;">
                            <div>
                                <a href="/product/details/${v['ProductId']}">
                                    <img class="border border-light rounded" src="/images/product/${v['ImageUrl']}" alt="${v['ProductName']}" width="100%">
                                </a>
                            </div>
                            <div style="width: 200vh;">    
                                <a href="/product/details/${v['ProductId']}" class="text-decoration-none text-light">${v['ProductName']}</a>
                                `;
                        if(v['Sizes'] && v['Prices']){
                            v['Sizes'].forEach(function(size, index) {
                                htmlbd += `
                                <div>
                                    <span>Size: ${size} - ${v['Prices'][index]}</span>
                                </div>
                                `;
                            });
                        }
                        htmlbd += `</div></div>`;
                });
                document.getElementById('tablebody').innerHTML = htmlbd;
                var currentPage = $page; // Trang hiện tại
                var lastPage = response.page; // Trang cuối cùng
                if(currentPage==1)
                    var pagination = '<li class="page-item disabled"><a class="page-link" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                else
                    var pagination = '<li class="page-item"><a class="page-link" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                for (var i = 1; i <= lastPage; i++) {
                    if (i == currentPage) {
                        // Nếu i là trang hiện tại, tạo một nút được chọn
                        pagination += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
                    } else {
                        // Nếu không, tạo một nút bình thường
                        pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getProductByClass(event, '+$id+',' + i + ')">' + i + '</a></li>';
                    }
                }
                if(currentPage==lastPage)
                pagination += '<li class="page-item disabled"><a class="page-link" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                else
                    pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getProductByClass(event, '+$id+',' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
@endsection
