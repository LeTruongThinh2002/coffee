@extends('shared/layout')
@section('body')
<div class="row text-light justify-content-center">
    <div class="col-9">
        <div class="card">
            <div class="card-header bg-light">
                <div class="card-title text-dark">
                    Chỉnh sửa sản phẩm {{$pd['ProductName']}}
                </div>
            </div>
            <div class="card-body bg-dark">
                        <div class="d-flex row ms-3">
                            <form id="submit-form" action="/product/doEdit/{{$pd['ProductId']}}" method="POST">
                                @csrf
                                <label for="">Product Name</label>
                                <input id="ProductName" type="text" name="ProductName" value="{{$pd['ProductName']}}">
                                <br>
                                <label for="">Category:  </label>
                                <select class="form-select" aria-label="Default select example" name="CategoryId">
                                    @foreach($cat as $v)
                                        @if($pd['CategoryId']===$v['CategoryId'])
                                            <option value="{{$v['CategoryId']}}" selected>{{$v['CategoryName']}}</option>
                                        @else
                                            <option value="{{$v['CategoryId']}}">{{$v['CategoryName']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <br>
                                <label for="">Description:</label>
                                <textarea name="Description" cols="30" rows="10">{!! htmlspecialchars_decode($pd['Description']) !!}</textarea>
                                <br>
                                <label for="">Image:  </label>
                                <input id="ImageUrl" type="file" name="ImageUrl">
                                <img src="/images/product/{{$pd['ImageUrl']}}" id="{{$pd['ProductId']}}" width="70" alt="{{$pd['ProductName']}}">
                                <br>
                                <div>Size</div>
                                @foreach($sz as $v)
                                <div class="form-check">
                                    @php
                                        $isChecked = in_array($v['SizeName'], $pd['Sizes']);
                                        $productId = $isChecked ? $pd['ProductId'] : $v['SizeId'];
                                        $price = $isChecked ? $pd['Prices'][array_search($v['SizeName'], $pd['Sizes'])] : '';
                                    @endphp
                                    <input class="form-check-input" type="checkbox" id="{{$v['SizeId']}}" name="Size" value="{{$v['SizeName']}}" {{$isChecked ? 'checked' : ''}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{$v['SizeName']}}
                                    </label>
                                    <label class="text-dark"> - Price</label>
                                    <input type="text" id="{{$v['SizeId']}}" name="Price" value="{{$price}}">
                                </div>
                                @endforeach
                                <br>
                                <a class="btn btn-danger" href="/product"><i class="fas fa-rectangle-xmark"></i></a>
                                <button id="btnNavbarSearch" type="submit" class="btn btn-warning"><i class="fa-solid fa-floppy-disk"></i></button>
                            </form>
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
    
    var initialCheckedSizes = [];
document.querySelectorAll('input[name="Size"]:checked').forEach(function(input) {
    initialCheckedSizes.push(input.value);
});
$(document).ready(function() {
    $('#submit-form').on('submit', function(e) {
        e.preventDefault();
        // Mảng để lưu trữ các size đã được chọn khi form được gửi đi
    var finalCheckedSizes = [];
    document.querySelectorAll('input[name="Size"]:checked').forEach(function(input) {
        finalCheckedSizes.push(input.value);
    });

    // Tìm ra các size đã bị bỏ chọn
    var uncheckedSizes = initialCheckedSizes.filter(function(size) {
        return !finalCheckedSizes.includes(size);
    });

    // Tạo một trường input ẩn để chứa các size đã bị bỏ chọn
    var hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'UncheckedSizes';
    hiddenInput.value = JSON.stringify(uncheckedSizes);
    this.appendChild(hiddenInput);

        // Tạo mảng hai chiều từ các giá trị SizeName và Price có cùng SizeId
        var sizeInputs = document.querySelectorAll('input[name="Size"]:checked');
        var priceInputs = document.querySelectorAll('input[name="Price"]');
        var array = [];
        for (var i = 0; i < sizeInputs.length; i++) {
            for (var j = 0; j < priceInputs.length; j++) {
                    if (sizeInputs[i].id === priceInputs[j].id) {
                        array.push([sizeInputs[i].value, priceInputs[j].value]);
                        break;
                    }
            }
        }
        var hiddenInputArray = document.createElement('input');
        hiddenInputArray.type = 'hidden';
        hiddenInputArray.name = 'SizePriceArray';
        hiddenInputArray.value = JSON.stringify(array);
        this.appendChild(hiddenInputArray);

    // Nếu không có tệp nào được chọn trong input, thêm src của thẻ img vào form
    var fileInput = document.querySelector('input[type="file"][name="ImageUrl"]');
    if (fileInput.files.length === 0) {
        var imgSrc = document.querySelector('img[id="' + productId + '"]').src;
        var hiddenInputImgSrc = document.createElement('input');
        hiddenInputImgSrc.type = 'hidden';
        hiddenInputImgSrc.name = 'ImageUrl';
        hiddenInputImgSrc.value = imgSrc;
        this.appendChild(hiddenInputImgSrc);
    }
    var formData = new FormData(this);
        var form = $(this);
        var url = form.attr('action');
//         for (var pair of formData.entries()) {
//     console.log(pair[0]+ ', ' + pair[1]); 
// }
        $.ajax({
            type: 'POST',
            url: url,
            data: formData, 
            processData: false, 
            contentType: false, 
            success: function(data)
            {
                if(data.success){
                    window.location.href='/product';
                    showToast('Đã chỉnh sửa ','product ');
                }
                else
                    showToast('Không thể chỉnh sửa ','product ');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                showToast('Không thể chỉnh sửa ','product do có lỗi ');
                console.log(textStatus, errorThrown);
            }
        });
    });
});

var productId = "{{$pd['ProductId']}}";
function htmlDecode(input){
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
}

$('textarea[name="Description"]').kendoEditor();

document.querySelector('input[type="file"][name="ImageUrl"]').addEventListener('change', function(e) {
    var file = e.target.files[0];
    var reader = new FileReader();
    reader.onloadend = function() {
        document.querySelector('img[id="' + productId + '"]').src = reader.result;
    }
    if (file) {
        reader.readAsDataURL(file);
    } else {
        document.querySelector('img[id="' + productId + '"]').src = "";
    }
});
function showToast(active,name) {
  $('#liveToast div.toast-body').text(active+' thành công '+name+'!');
  $('#liveToast').toast('show');
  startTime = new Date();
  updateTime();
  setInterval(updateTime, 1000);
};
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