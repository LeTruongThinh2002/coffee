@extends('shared/layout')
@section('class-body')
    id="theme8" style="color:white !important;"
@endsection
@section('body')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Details product</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-white">Detail</li>
            </ol>
        </div>
        <!-- Single Page Header End -->
<!-- Single Product Start -->
<div class="container-fluid py-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-12 col-xl-12">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a>
                                        <img src="/images/product/{{$arr['ImageUrl']}}" class="img-fluid w-100 rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3" style="color: rgba(255, 255, 255, .5);">{{$arr['ProductName']}}</h4>
                                <p class="mb-3">Category: {{$arr['CategoryName']}}</p>
                                
                                <form action="/cart/add" method="post">
                                    @csrf
                                    <div class="d-block mb-2">
                                        Size:
                                        <select class="form-select" name="Size" style="width: fit-content;">
                                        @foreach($arr['Sizes'] as $index => $size)
                                            <option value="{{$size}}">{{$size}} - {{$arr['Prices'][$index]}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="d-block mb-3" style="width: fit-content;">
                                        Amount:
                                        <input type="hidden" name="ProductId" value="{{$arr['ProductId']}}">
                                        <input type="number" name="Amount" value="1" min="1" max="100" class="qty form-control form-control-sm text-center border-0">
                                    </div>
                                    <button class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                </form>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Description</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <p class="text-break">{!! htmlspecialchars_decode($arr['Description']) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="fw-bold mb-0" style="color: rgba(255, 255, 255, .5);">Related products</h1>
                <div class="vesitable">
                    <div class="owl-carousel vegetable-carousel justify-content-center">
                        @foreach($drr as $v)
                            <div class="border border-primary rounded position-relative vesitable-item">
                                <div class="vesitable-img">
                                    <img src="/images/product/{{$v['ImageUrl']}}" class="img-fluid w-100 rounded-top" alt="">
                                </div>
                                <!-- <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div> -->
                                <div class="p-4 rounded-bottom">
                                    <h4 class="text-truncate" style="color: rgba(255, 255, 255, .5);">{{$v['ProductName']}}</h4>
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
    <div class="toast-body" style="width: fit-content;">
    </div>
  </div>
</div>
@section('scripts')
<script>
      function showToast(active,name) {
  $('#liveToast div.toast-body').text(active+' thành công '+name+'!');
  $('#liveToast').toast('show');
  startTime = new Date();
  updateTime();
  setInterval(updateTime, 1000);
};
$(document).ready(function() {
    $('.qty').on('change', function() {
        var value = $(this).val();
        if (value < 1) {
            elements = document.getElementsByClassName('qty');
            for(var i = 0; i < elements.length; i++) {
                elements[i].value = 1;
            }
             return;
            }
    })});
    $(document).ready(function() {
    $('form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: '/cart/add',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success){
                    showToast('Thêm sản phẩm vào giỏ hàng ',' ');
                }
                else
                    showToast('Không thể thêm sản phẩm vào giỏ hàng ',' ');
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
                console.log(jqXHR);
                showToast('Không thể thêm sản phẩm vào giỏ hàng ','do có lỗi');
            }
        });
    });
});

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
