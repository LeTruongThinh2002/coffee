@extends('shared.layout')
@section('body')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Invoice</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active text-white">Invoice</li>
            </ol>
        </div>
        <!-- Single Page Header End -->
<div class="bg-light border rounded-3 p-4 pt-2 pb-2 m-3">
  <div>
    <table class="table table-light mb-0" style="table-layout: fixed; width: 100%;"><thead>
            <tr>
                    <th>Order number</th>
                    <th>Date</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Product</th>
                </tr>
            </thead>
    </table>
  </div>
  <div class="overflow-auto" style="max-height: 60vh;">
    <table class="table table-light table-hover" style="table-layout: fixed; width: 100%;">
            <tbody>
              @if(isset($msg))
                <td class="text-break">{{$msg}}</td>
              @else
                @foreach($arr as $v)
                @php
                    $timestamp = strtotime($v['created_at']);
                    $date = date('Y-m-d', $timestamp);
                    $time = date('H:i:s', $timestamp);
                @endphp
                <tr>
                    <td class="text-break">#{{$v['InvoiceId']}}</td>
                    <td class="text-break">{{$time}}, {{$date}}</td>
                    <td class="text-break">{{$v['Phone']}}</td>
                    <td class="text-break">{{$v['Address']}}</td>
                    <td><button class="btn btn-warning btn_details" name="{{$v['InvoiceId']}}">
                      <i class="bi bi-bag-check"></i>
                    </button></td>
                </tr>
                @endforeach
              @endif
            </tbody>
      </table>
  </div>
</div>
<div class="modal fade overflow" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <form name="frm" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="exampleModalLabel">Detail Order</h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button  type="button" class="btn btn-danger" data-bs-dismiss="modal">
                <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@section('scripts')
<script>
  function htmlDecode(input){
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
};
  $(document).ready(function(){
    $(".btn_details").click(function(){
        var id=$(this).attr('name');
        console.log(id);
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            url: "/invoice/details/"+id,
            type: "POST",
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
              if(response.success){
                // Thêm dữ liệu mới vào bảng
                var totalOP=0;
                var html = `<div class="card my-4 table-responsive">
                <table class="table table-white m-3 table-hover overflow">
                <thead>
                        <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Total Price</th>
                    </tr>
                        </thead>
                        <tbody>`;
                $.each(response.arr, function(i, v) {
                    html+=`
                                <tr>
                                    <td>`+v.ProductName+`</td>
                                    <td><img src="/images/product/`+v.ImageUrl+`" alt="`+v.ProductName+`" width="100"></td>
                                    <td>`+v.Size+`</td>
                                    <td>`+v.Price+`</td>
                                    <td>`+v.Amount+`</td>
                                    <td>`+v.TotalPrice+`</td>
                                </tr>`;
                                totalOP+=parseInt(v.TotalPrice);
                });
                html+=`
                </tbody>
                  </table>
              </div>
              <div class="mt-2 text-dark">
                Total order price: `+totalOP+`
              </div>`;
            //html=htmlDecode(html);
            $("#modalDetails h5.modal-title").text('Detail Order #'+id);
            $("#modalDetails div.modal-body").html(html);
            //$("#modalDetails").html(html);
                $("#modalDetails").modal('show');
              }
                else
                    console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(jqXHR,textStatus, errorThrown);
            }
        });
    });
});

</script>
@endsection
@endsection