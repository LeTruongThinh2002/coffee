@extends('shared.layout')
@section('body')
<div style="display: flex; align-items: center;">
  <h4 class="fw-bold text-light mt-2 mb-3 p-0">Invoice</h4>
  <hr class="text-light" style="flex-grow: 1; margin-left: 10px;">
</div>

<form class="d-none d-md-inline-block form-inline ms-4 me-1 my-2 my-md-0">
                
                <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="checkTime" id="checkDay" >
                        <div class="d-flex col">
                            <label class="me-1  text-light fw-bold" for="">DAY</label>
                            <input class="form-control" type="date" id="oneday" name="checkDay">
                        </div>
                        <nav class="mt-2" aria-label="Page navigation example">
                          <ul class="pagination" id="pagination">
                          </ul>
                        </nav>
                    </div>
            </form>
            
<div class="bg-light border rounded-3 p-4 pt-2 pb-2 mt-3">
  <div>
    <table id="dataTable" class="table table-light mb-0 table-hover" style="table-layout: fixed; width: 100%;"><thead>
            <tr>
                    <th id="btn-orderBy" name="ASC">User Name</th>
                    <th>Email</th>
                    <th>Order number</th>
                    <th>Date</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Product</th>
                </tr>
            </thead>
            <tbody id="tablebody"></tbody>
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
$(document).ready(function() {
    $('#dataTable').DataTable({
        paging: false,  // Tắt phân trang
        lengthChange: false,  // Tắt chọn số lượng hiển thị
        info:false,
        
        columnDefs: [
            { orderable: false, targets: [1,2,3,4,5,6] }  // Tắt sắp xếp cho cột 1 và 2
        ]
    });
    $('.dataTables_filter input').on('keyup', function(e) {
      var searchQuery = $(this).val();
      if (searchQuery.length > 0 && searchQuery.trim() != '') {
        
          searchBoxInv(event,1);
      }else{
        getInvoiceAll(event, 1);
      }
    });
});
$(document).on("click","th[id='btn-orderBy']", function() {
    var order = this.getAttribute("name");
    if(order == "ASC") {
        this.setAttribute("name", "DESC");
    } else {
        this.setAttribute("name", "ASC");
    }
    var isChecked = document.getElementById('checkDay').checked;
    if(isChecked){
      getDay(event,1);
      return;
    }
    var $searchQuery=$('.dataTables_filter input').val();
      if ($searchQuery.length > 0 && $searchQuery.trim() != '') {
          searchBoxInv(event,1);
      }else
        getInvoiceAll(event, 1);
});
function getInvoiceAll(event, $page){
    event.preventDefault();
    var order=document.getElementById("btn-orderBy").getAttribute('name');
    //console.log(order);
    var htmlbd;
    $.ajax({
        url: '/invoice/doAdmins?page='+$page,
        type: 'POST',
        data: {
            'order':order,
            _token: '{{csrf_token()}}'
        },
        success: function(response) {
          if(response.success) {
              htmlbd = '';
              $.each(response.arr, function(i, v) {
                  htmlbd += `
                      <tr>
                          <td class="text-break">${v.UserName}</td>
                          <td class="text-break">${v.Email}</td>
                          <td>#${v.InvoiceId}</td>
                          <td>${v.time}, ${v.date}</td>
                          <td>${v.Phone}</td>
                          <td>${v.Address}</td>
                          <td><button class="btn btn-warning btn_details" name="${v.InvoiceId}">
                              <i class="bi bi-bag-check"></i>
                          </button></td>
                      </tr>`;
              });
              document.getElementById('tablebody').innerHTML = htmlbd;
              var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a class="page-link" href="#" onclick="getInvoiceAll(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" href="#" onclick="getInvoiceAll(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getInvoiceAll(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" href="#" onclick="getInvoiceAll(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getInvoiceAll(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
    getInvoiceAll(event, 1);
  });
  function htmlDecode(input){
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
};
$(document).ready(function() {
    $('#checkDay').change(function(e) {
        if ($(this).is(':checked')) {
            var date = $('#oneday').val();
            var searchBoxInv1 = $('.dataTables_filter input').val();
            if (date && !searchBoxInv1) {
              getDay(e,1);
            }else if(searchBoxInv1 && date){
              searchBoxInv(e,1);
            }else if(!searchBoxInv1 && !date){
              getInvoiceAll(event, 1);
            }
        }else{
          searchBoxInv(e,1);
        }
    });
});
function getDay(e,$page){
  var date = $('#oneday').val();
  var order=document.getElementById("btn-orderBy").getAttribute("name");
  $.ajax({
                    url: '/invoice/searchDay?page='+$page, // Thay đổi thành endpoint của bạn
                    type: 'POST',
                    data: {
                        'date': date,
                        'order':order,
                        _token: '{{csrf_token()}}' // Thêm CSRF token vào đây
                    },
                    success: function(response) {
                      if(response.success) {
                          var htmlbd = '';
                          $.each(response.arr, function(i, v) {
                              htmlbd += `
                                  <tr>
                                      <td class="text-break">${v.UserName}</td>
                                      <td class="text-break">${v.Email}</td>
                                      <td>#${v.InvoiceId}</td>
                                      <td>${v.time}, ${v.date}</td>
                                      <td>${v.Phone}</td>
                                      <td>${v.Address}</td>
                                      <td><button class="btn btn-warning btn_details" name="${v.InvoiceId}">
                                          <i class="bi bi-bag-check"></i>
                                      </button></td>
                                  </tr>`;
                          });
                          if(htmlbd==''){
                            htmlbd+='Khong tim thay ket qua phu hop';
                          }
                          document.getElementById('tablebody').innerHTML = htmlbd;
                          var currentPage = $page; // Trang hiện tại
                          var lastPage = response.page; // Trang cuối cùng
                          if(currentPage==1)
                            var pagination = '<li class="page-item disabled"><a class="page-link" href="#" onclick="getDay(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                          else
                            var pagination = '<li class="page-item"><a class="page-link" href="#" onclick="getDay(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                          for (var i = 1; i <= lastPage; i++) {
                              if (i == currentPage) {
                                  // Nếu i là trang hiện tại, tạo một nút được chọn
                                  pagination += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
                              } else {
                                  // Nếu không, tạo một nút bình thường
                                  pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getDay(event, ' + i + ')">' + i + '</a></li>';
                              }
                          }
                          if(currentPage==lastPage)
                          pagination += '<li class="page-item disabled"><a class="page-link" href="#" onclick="getDay(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                          else
                            pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getDay(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                          document.getElementById('pagination').innerHTML = pagination;
                      } else {
                          htmlbd = `<tr><td>${response.msg}</td></tr>`;
                          document.getElementById('tablebody').innerHTML = htmlbd;
                          document.getElementById('pagination').innerHTML = '';
                          console.log(response.msg);
                      }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
}

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
    function searchBoxInv(e,$page){
      e.preventDefault();
      var isChecked = document.getElementById('checkDay').checked;
      var day='';
      if(isChecked){
        day=document.getElementById('oneday').value;
      }
      if(!day)
        day='f';
      $searchQuery=$('.dataTables_filter input').val();
      if ($searchQuery.length > 0 && $searchQuery.trim() != '') {
        var order=document.getElementById("btn-orderBy").getAttribute("name");
        $.ajax({
          url: '/invoice/searchBoxInv?page='+$page, // Thay đổi thành endpoint của bạn
          type: 'POST',
          data: {
            'q': $searchQuery,
            'day':day,
            'order':order,
              _token: '{{csrf_token()}}' // Thêm CSRF token vào đây
          },
          success: function(response) {
            if(response.success) {
                htmlbd = '';
                $.each(response.dataSB, function(i, k) {
                      htmlbd += `
                        <tr>
                            <td class="text-break">${k.UserName}</td>
                            <td class="text-break">${k.Email}</td>
                            <td>#${k.InvoiceId}</td>
                            <td>${k.time}, ${k.date}</td>
                            <td>${k.Phone}</td>
                            <td>${k.Address}</td>
                            <td><button class="btn btn-warning btn_details" name="${k.InvoiceId}">
                                <i class="bi bi-bag-check"></i>
                            </button></td>
                        </tr>`;
                });
                if(htmlbd==''){
                  htmlbd+='Khong tim thay ket qua phu hop';
                }
                document.getElementById('tablebody').innerHTML = htmlbd;
                var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a class="page-link" href="#" onclick="searchBoxInv(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" href="#" onclick="searchBoxInv(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" href="#" onclick="searchBoxInv(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" href="#" onclick="searchBoxInv(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" href="#" onclick="searchBoxInv(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              document.getElementById('pagination').innerHTML = pagination;
            } else {
                htmlbd = `<tr><td>${response.msg}</td></tr>`;
                document.getElementById('tablebody').innerHTML = htmlbd;
                document.getElementById('pagination').innerHTML = '';
            }
          },
          error: function(error) {
              console.log(error);
          }
        });
      }else{
        getInvoiceAll(event,1);
      }
    }
    var today = new Date().toISOString().split('T')[0];
    document.getElementById("oneday").max = today;
  $(document).on('click','.btn_details',function(e){
      e.preventDefault(); 
        var id=$(this).attr('name');
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


</script>
@endsection
@endsection
@endsection