@extends('shared.layout')
@section('title','Cart')
@section('body')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table text-light">
                        <thead>
                          <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(isset($msg))
                            <td colspan="7" class="text-center">{{$msg}}</td>
                            @else
                                @php
                                    Session::put('totalpr',0);
                                @endphp
                                @foreach($arr as $v)
                                    @php
                                    $totalpr = Session::get('totalpr') + $v['Price'] * $v['Amount'];
                                    Session::put('totalpr', $totalpr);
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="d-flex align-items-center">
                                                <img src="/images/product/{{$v['ImageUrl']}}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="" alt="">
                                            </div>
                                        </th>
                                        <td>
                                            <p class="mb-0 mt-4">{{$v['ProductName']}}</p>
                                        </td>
                                        <td id="{{$v['ProductId']}}" name="Size">
                                            <p class="mb-0 mt-4">{{$v['Size']}}</p>
                                        </td>
                                        <td class="pri_ce" id="{{$v['ProductId']}}" name="{{$v['Size']}}">
                                            <p class="mb-0 mt-4">{{$v['Price']}}</p>
                                        </td>
                                        <td>
                                            <input type="number" class="qty form-control form-control-sm mb-0 mt-4" style="width: fit-content;" min="1" id="{{$v['ProductId']}}" value="{{$v['Amount']}}" name="{{$v['Size']}}">
                                        </td>
                                        <td>
                                            <p class="mb-0 mt-4 total_p" id="{{$v['ProductId']}}" name="{{$v['Size']}}">{{$v['Price'] * $v['Amount']}}</p>
                                        </td>
                                        <td id="{{$v['ProductId']}}">
                                            <button class="btn btn-md rounded-circle bg-light border mt-4 btn-trash" id="{{$v['ProductId']}}" name="{{$v['Size']}}">
                                                <i class="fas fa-dumpster-fire"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="row g-4 justify-content-end">
                    <!-- <div class="col-8"></div> -->
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Shipping</h5>
                                    <div class="">
                                        <p class="mb-0 text-dark">Free ship</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p id="totalpr" class="mb-0 pe-4 text-dark">@php if(Session::get('totalpr')==0) echo 0;
                                    else 
                                    echo Session::get('totalpr'); Session::forget('totalpr'); @endphp</p>
                            </div>
                            <a href="/cart/checkout" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout <i class="fas fa-dolly-flatbed"></i></a>
                        </div>
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
    function showToast(active,name) {
  $('#liveToast div.toast-body').text(active+' thành công '+name+'!');
  $('#liveToast').toast('show');
  startTime = new Date();
  updateTime();
  setInterval(updateTime, 1000);
};
$(document).ready(function() {
    $('.qty').on('change', function() {
        var id = $(this).attr('id');
        var size = $(this).attr('name');
        var value = $(this).val();
        if (value < 1) {
            elements = document.getElementsByClassName('qty');
            for(var i = 0; i < elements.length; i++) {
                elements[i].value = 1;
            }
             return;
            }
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: '/cart/edit/' + id,
            type: 'POST',
            data: {
                'Amount': value,
                'Size': size,
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success){
                    showToast('Chỉnh sửa ','số lượng sản phẩm '+name);
                    var price = $('td#'+id+'.pri_ce[name="'+size+'"]').text();
                    console.log(price);
                    console.log(size);
                    var newTotal = price * value;
                    $('td#'+id+'.total_p[name="'+size+'"]').text(newTotal);
                }
                else
                    showToast('Không thể chỉnh sửa ','số lượng sản phẩm '+name);
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
                console.log(jqXHR);
                console.log(size);
                showToast('Không thể chỉnh sửa ','số lượng sản phẩm '+name+' do có lỗi');
            }
        });
    });
});
$(document).ready(function() {
    $('.btn-trash').on('click', function(e) {
        e.preventDefault(); 
        var id = $(this).attr('id'); 
        var size = $(this).attr('name');
        var url = '/cart/delete/' + id; 
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: url,
            type: 'POST',
            data: {
                'Size': size,
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success){
                    var totalpr = $('#totalpr');
                    var otherElement = $('p#' + id + '.total_p[name="' + size + '"]');
                    totalpr.text(parseInt(totalpr.text()) - parseInt(otherElement.text()));

                    $('td#' + id + ' button[name="' + size + '"]').closest('tr').remove();
                    showToast('Đã xóa ',' sản phẩm này');
                }
                else
                    showToast('Không thể xóa ','sản phẩm này');
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
                console.log(jqXHR);
                console.log(size);
                showToast('Không thể xóa ',' sản phẩm này do có lỗi');
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