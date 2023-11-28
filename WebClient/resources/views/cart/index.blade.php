@extends('shared.layout')
@section('title','Cart')
@section('body')
<div style="display: flex; align-items: center;">
  <h4 class="fw-bold text-light mt-2 mb-3 p-0">Shopping Cart</h4>
  <hr class="text-light" style="flex-grow: 1; margin-left: 10px;">
</div>
<div class="bg-light border rounded-3 p-4 pt-2 pb-2 mt-2">
  <div>
    <table class="table table-light mb-0" style="table-layout: fixed; width: 100%;">
            <thead>
            <tr>
            <th>ProductName</th>
            <th>Image</th>
            <th>Size</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Total Price</th>
            <th>Delete</th>
        </tr>
            </thead>
    </table>
  </div>
  <div class="overflow-auto" style="max-height: 53vh;">
    <table class="table table-light table-hover" style="table-layout: fixed; width: 100%;">
            <tbody>
                @if(isset($msg))
                <td class="text-center">{{$msg}}</td>
                @else
                    @foreach($arr as $v)
                    <tr>
                        <td>{{$v['ProductName']}}</td>
                        <td><img src="/images/product/{{$v['ImageUrl']}}" alt="{{$v['ProductName']}}" width="100"></td>
                        <td id="{{$v['ProductId']}}" name="Size">{{$v['Size']}}</td>
                        <td class="pri_ce" id="{{$v['ProductId']}}" name="{{$v['Size']}}">{{$v['Price']}}</td>
                        <td>
                            <input min="1" type="number" id="{{$v['ProductId']}}" value="{{$v['Amount']}}" name="{{$v['Size']}}" class="qty w-75 form-control">
                        </td>
                        <td class="total_p" id="{{$v['ProductId']}}" name="{{$v['Size']}}">{{$v['Price'] * $v['Amount']}}</td>
                        <td id="{{$v['ProductId']}}"><a class="btn btn-primary bg-danger text-light rounded-pill mt-3 btn-trash" id="{{$v['ProductId']}}" name="{{$v['Size']}}"><i class="bi bi-trash"></i></a>
                    </tr>
                    @endforeach
                @endif
            </tbody>
      </table>
  </div>
</div>
@if(!isset($msg))
<div class="text-center"><a href="/cart/checkout" class="btn btn-warning text-dark rounded-pill mt-2"><i class="bi bi-cash-coin"></i></a></div>
@endif
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
        $.ajax({
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
            url: url,
            type: 'POST',
            data: {
                'Size': size,
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success){
                    $('td#' + id + ' a[name="' + size + '"]').closest('tr').remove();
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