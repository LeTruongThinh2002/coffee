@extends('shared.layout')
@section('body')
<div style="display: flex; align-items: center;">
  <h4 class="fw-bold text-light mt-2 mb-3 p-0">Invoice</h4>
  <hr class="text-light" style="flex-grow: 1; margin-left: 10px;">
</div>
<div class="bg-light border rounded-3 p-4 pt-2 pb-2 mt-3">
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
                <td>{{$msg}}</td>
              @else
                @foreach($arr as $v)
                @php
                    $timestamp = strtotime($v['created_at']);
                    $date = date('Y-m-d', $timestamp);
                    $time = date('H:i:s', $timestamp);
                @endphp
                <tr>
                    <td>#{{$v['InvoiceId']}}</td>
                    <td>{{$time}}, {{$date}}</td>
                    <td>{{$v['Phone']}}</td>
                    <td>{{$v['Address']}}</td>
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
<div class="modal fade " id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width: fit-content; height: fit-content;">
    <div class="modal-dialog modal-xl">
        <form name="frm" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="exampleModalLabel">Detail Order</h5>
            </div>
            <div class="modal-body" style="width: fit-content; height: fit-content;">
            </div>
            <div class="modal-footer">
                <button  type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-rectangle-xmark"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@section('style-btn')
<style>
.modal {
  /* Đặt modal ở giữa màn hình */
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
@section('scripts')
<script>
  function htmlDecode(input){
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
};
  $('body').on('click', '.status', function() {
        var id=$(this).attr('id');
        $('form[name="frm"]').attr('action','/invoice/status/'+id);
        $.post('/invoice/details/${id}',{_token: $('input[name="_token"]').val()},(d)=>
        {
            $('select[name="status_id"]').val(d['status_id']);
            $(rs).html(`
            <tr>
                <th>So don hang</th>
                <td>${d['id']}</td>
            </tr>
            <tr>
                <th>Ngày</th>
                <td>${d['created_at']}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>${d['phone']}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>${d['address']},${d['ward_name']}</td>
            </tr>
            `);
            
        });
        $('#statusModal').modal('show');
  });
  $(document).ready(function(){
    $(".btn_details").click(function(){
        var id=$(this).attr('name');
        console.log(id);
        $.ajax({
            url: "/invoice/details/"+id,
            type: "POST",
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
              if(response.success){
                // Thêm dữ liệu mới vào bảng
                var totalOP=0;
                var html = `<div  class="bg-light border rounded-3 p-4 pt-2 pb-2 mt-2">
              <div>
                <table class="table table-light mb-0" style="table-layout: fixed; width: 50rem;">
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
                </table>
              </div>
              <div class="overflow-auto" style="max-height: 53vh;">
                <table class="table table-light table-hover" style="table-layout: fixed; width:50rem">
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
                                totalOP+=v.TotalPrice;
                });
                html+=`
                        </tbody>
                  </table>
              </div>
              <div class="mt-2">
                Total order price: `+totalOP+`
              </div>
            </div>
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
@endsection