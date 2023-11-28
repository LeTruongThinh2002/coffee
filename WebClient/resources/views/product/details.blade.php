@extends('shared/layout')
@section('body')
<div class="row text-light justify-content-center">
    <div class="col-9">
        <div class="card">
            <div class="card-header bg-light">
                <div class="card-title text-dark">
                    Thông tin sản phẩm
                </div>
            </div>
            <div class="card-body bg-dark">
                <div class="d-flex row">
                    <div class="d-flex column">
                        <div>
                            <img src="/images/product/{{$arr['ImageUrl']}}" alt="{{$arr['ProductName']}}" width="250">
                        </div>
                        <div class="d-flex row ms-3">
                            <form action="/cart/add" method="post">
                                @csrf
                                <div class="d-block mb-2">
                                    Size:
                                    <select class="form-select" name="Size">
                                    @foreach($arr['Sizes'] as $index => $size)
                                        <option value="{{$size}}">{{$size}} - {{$arr['Prices'][$index]}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                Số lượng:
                                <input type="hidden" name="ProductId" value="{{$arr['ProductId']}}">
                                <input type="number" name="Amount" value="1" min="1" max="100">
                                <button class="btn btn-warning ms-5"><i class="bi bi-bag-check"></i></button>
                            </form>
                        </div>
                        
                    </div>
                    <div class="mt-3 fs-5 text-decoration-underline">
                    {{$arr['ProductName']}}
                    </div>
                    <div class="col-8 overflow-hidden mt-2">
                        <div>{!! htmlspecialchars_decode($arr['Description']) !!}</div>
                    </div>
                </div>
            </div>
        </div>
        <p class="mt-3 fs-4">Recommend</p>
        <div class="d-flex button-re" style="overflow-x: visible;">
            @foreach($drr as $v)
            <div class="d-inline me-3 p-2 ps-1 pe-1 text-center rounded-2 changes" style="width: 20vh;">
                <a href="/product/details/{{$v['ProductId']}}">
                    <img class="border border-light rounded" src="/images/product/{{$v['ImageUrl']}}" alt="{{$v['ProductName']}}" width="80%">
                </a>
                <br>
                <a href="/product/details/{{$v['ProductId']}}" class="text-decoration-none text-light">{{$v['ProductName']}}</a>
            </div>
            @endforeach
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
    <div class="toast-body" style="width: fit-content;">
    </div>
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
</style>
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
    $('form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
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
@endsection