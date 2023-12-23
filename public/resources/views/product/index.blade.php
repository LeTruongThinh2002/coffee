@extends('shared.layoutadmin')
@section('title','Product')
@section('body')

<div class="container-fluid py-4">
      <div class="row">
<div class="col-lg-12 col-md-6 mb-4">
          <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 d-flex justify-content-between align-items-center">
                <h6 class="text-white text-capitalize ps-3">Product</h6>
                <button type="button" class="btn btn-warning hover-overlay shadow me-3" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" title="Create Role">
                    <i class="bi bi-bookmark-plus-fill fa-lg"></i>
                </button>  
            </div>
            </div>
            <div class="card-body m-3 px-0 pb-2">
              <div class="table-responsive p-0">
                <table id="dataTable" class="table table-hover align-items-center mb-0" style="table-layout: fixed;">
                  <thead>
                      <tr>
                        <th class="text-secondary font-weight-bolder ps-2" id="btn-orderBy" name="ASC">Product Name</th>
                        <th class="text-secondary font-weight-bolder ps-2">Category</th>
                        <th class="text-secondary font-weight-bolder ps-2">Description</th>
                        <th class="text-secondary font-weight-bolder ps-2">Image</th>
                        <th class="text-secondary font-weight-bolder ps-2">Price</th>
                        <th class="text-secondary font-weight-bolder ps-2">Command</th>
                    </tr>
                  </thead>
                  <tbody id="tablebody">
                    
                    
                  </tbody>
                </table>
                <nav class="mt-2 d-flex justify-content-center" aria-label="Page navigation example">
                  <ul class="pagination" id="pagination">
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div></div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast hide" product="alert" aria-live="assertive" aria-atomic="true">
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
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="frm_delete" action="/product/delete" method="post" enctype="multipart/form-data" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: black !important;" id="exampleModalLabel">Are you sure delete?</h5>
            </div>
            <div class="modal-body">
            <label class="text-dark ">Product Name:</label> 
            @csrf 
            <span class="text-dark" name="ProductName"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
                <button class="btn btn-warning">
                <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="submit_form" name="frm_add" action="/product/cadd" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold"  style="color: black !important;" id="exampleModalLabel">Create Product</h5>
            </div>
            <div class="modal-body">
            <input type="hidden" name="ProductId" value="312832">
            <label class="text-dark ">Product Name:</label>  
            <input type="text" name="ProductName">
            <br>
            <label class="text-dark">Category</label>
            <select name="CategoryId" id="CategorySelect">
            </select>
            <br>
            <label class="text-dark">Description</label>
            <br>
            <textarea name="Description" cols="30" rows="10"></textarea>
            <br>
            <label class="text-dark">Image</label> 
            <input id="file" type="file" name="ImageUrl">
            <br>
            <label class="text-dark">Size</label> 
            <div id="SizeAdd">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
                <button class="btn btn-warning" type="submit">
                <i class="fas fa-cloud-download-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@section('scripts')
<script>
  $(document).ready(function() {
    $('#dataTable').DataTable({
        paging: false,  // Tắt phân trang
        lengthChange: false,  // Tắt chọn số lượng hiển thị
        info:false,
        columnDefs: [
            { orderable: false, targets: [1, 2, 3, 4, 5] }  // Tắt sắp xếp cho cột 1 và 2
        ]
    });
    $('.dataTables_filter input').on('keyup', function(e) {
      var searchQuery = $(this).val();
      if (searchQuery.length > 0 && searchQuery.trim() != '') {
        
          searchBoxPro(event,1);
      }else{
        getProductInx(event, 1);
      }
    });
});
function searchBoxPro(e,$page){
      e.preventDefault();
      $searchQuery=$('.dataTables_filter input').val();
      if ($searchQuery.length > 0 && $searchQuery.trim() != '') {
        var order=document.getElementById("btn-orderBy").getAttribute("name");
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
          url: '/product/searchBoxPro?page='+$page, // Thay đổi thành endpoint của bạn
          type: 'POST',
          data: {
            'q': $searchQuery,
            'order':order,
              _token: '{{csrf_token()}}' // Thêm CSRF token vào đây
          },
          success: function(response) {
            if(response.success) {
              htmlbd = ``;
              $.each(response.product, function(i, v) {
                var descript=htmlDecode(v.Description);
                htmlbd += `
                <tr>
                    <td class="td_input" id="${v.ProductId}">${v.ProductName}</td>
                    <td>${v.CategoryName}</td>
                    <td class=" text-wrap">${descript}</td>
                    <td>
                        <img class="img-fluid border border-light rounded" src="/images/product/${v.ImageUrl}" alt="${v.ProductName}" width="100">
                    </td>
                        <td style="width: fit-content;">
                    `;
                    if(v['Sizes'] && v['Prices']){
                        v['Sizes'].forEach(function(size, index) {
                            htmlbd += `
                            <span>Size: ${size} - ${v['Prices'][index]}</span>
                            <br>
                            `;
                        });
                    }
                    htmlbd += `</td><td>
                        <a class="btn btn-warning btn_trash hover-overlay" id="${v.ProductId}" name="${v.ProductName}" data-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill"></i></a>
                        <a href="/product/edit/${v.ProductId}" class="btn btn-warning btn_edit hover-overlay" data-toggle="tooltip" title="Edit"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    </tr>`;
              });
              document.getElementById('tablebody').innerHTML = htmlbd;
              var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a class="page-link" style="color:black !important;" href="#" onclick="searchBoxPro(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" style="color:black !important;" href="#" onclick="searchBoxPro(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" style="color:black !important;" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" style="color:black !important;" href="#" onclick="searchBoxPro(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" style="color:black !important;" href="#" onclick="searchBoxPro(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" style="color:black !important;" href="#" onclick="searchBoxPro(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
      }else{
        getProductInx(event,1);
      }
    }
$(document).on("click","th[id='btn-orderBy']", function(event) {
    var order = this.getAttribute("name");
    if(order == "ASC") {
        this.setAttribute("name", "DESC");}
    else{
        this.setAttribute("name", "ASC");
    }
    $searchQuery=$('.dataTables_filter input').val();
      if ($searchQuery.length > 0 && $searchQuery.trim() != ''){
        searchBoxPro(event,1);
      }else{
        getProductInx(event, 1);
      }
    
});
function htmlDecode(input){
  var doc = new DOMParser().parseFromString(input, "text/html");
  return doc.documentElement.textContent;
};
function getProductInx(event, $page){
    event.preventDefault();
    $order=document.getElementById("btn-orderBy").getAttribute("name");
    var htmlbd;
var urla='/product/getProductInx?page='+$page+'&order='+$order;
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
              var select = ``;
              $.each(response.cat,function(i,v){
                select+=`
                <option value="${v.CategoryId}">${v.CategoryName}</option>
                `;
              });
              document.getElementById('CategorySelect').innerHTML = select;
              var size = ``;
              $.each(response.sz,function(i,v){
                size+=`
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="Size" id="${v.SizeId}" value="${v.SizeName}">
                <label class="form-check-label" for="flexCheckDefault">
                ${v.SizeName}
                </label>
                <label class="text-dark"> - Price</label>
                <input type="text" name="Price" id="${v.SizeId}">
            </div>
                `;
              });
              document.getElementById('SizeAdd').innerHTML = size;
              htmlbd = ``;
              $.each(response.product, function(i, v) {
                var descript=htmlDecode(v.Description);
                htmlbd += `
                <tr>
                    <td class="td_input" id="${v.ProductId}">${v.ProductName}</td>
                    <td>${v.CategoryName}</td>
                    <td class=" text-wrap">${descript}</td>
                    <td>
                        <img class="border border-light rounded" src="/images/product/${v.ImageUrl}" alt="${v.ProductName}" width="100">
                    </td>
                        <td style="width: fit-content;">
                    `;
                    if(v['Sizes'] && v['Prices']){
                        v['Sizes'].forEach(function(size, index) {
                            htmlbd += `
                            <span>Size: ${size} - ${v['Prices'][index]}</span>
                            <br>
                            `;
                        });
                    }
                    htmlbd += `</td><td>
                        <a class="btn btn-warning btn_trash hover-overlay" id="${v.ProductId}" name="${v.ProductName}" data-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill"></i></a>
                        <a href="/product/edit/${v.ProductId}" class="btn btn-warning btn_edit hover-overlay" data-toggle="tooltip" title="Edit"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    </tr>`;
              });
              document.getElementById('tablebody').innerHTML = htmlbd;
              var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a class="page-link" style="color:black !important;" href="#" onclick="getProductInx(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" style="color:black !important;" href="#" onclick="getProductInx(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" style="color:black !important;" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" style="color:black !important;" href="#" onclick="getProductInx(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" style="color:black !important;" href="#" onclick="getProductInx(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" style="color:black !important;" href="#" onclick="getProductInx(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
    getProductInx(event, 1);
  });
function showToast(active,name) {
  $('#liveToast div.toast-body').text(active+' thành công '+name+'!');
  $('#liveToast').toast('show');
  startTime = new Date();
  updateTime();
  setInterval(updateTime, 1000);
};
function click(btn,idm,item,kt){
    $('body').on('click', btn, function() {
    var name = $(this).attr('name');
    var id = $(this).attr('id');
    $('#'+idm+' '+item+'[name="ProductName"]').text(name);
    $('#'+idm+' form').data('id', id);
    $('#'+idm).modal('show');
  });
}

click('.btn_trash','modalDelete','span');
var trash;
$('form[name="frm_delete"]').on('submit', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/product/delete/' + id,
    type: 'POST',
    data: { _token: $('input[name="_token"]').val() },
    success: function(data) {
      console.log(data);
      trash=$('td.td_input[id="' + id + '"]').text();
      if(data.success == true) {
        getProductInx(event, 1);
        $('#modalDelete').modal('hide');
        showToast('Đã xóa ','product '+trash);
      } else {
        $('#modalDelete').modal('hide');
        showToast('Không thể xóa ','product');
      }
    },error: function(data) {
      console.log(data);
      $('#modalDelete').modal('hide');
      showToast('Không thể xóa ','product do có lỗi');
    }
  });
});
$(document).ready(function() {
    $('#submit_form').on('submit', function(e) {
        e.preventDefault();
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
  
  var formData = new FormData(this);
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/product/cadd',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(data) {
      console.log(data);
      if(data.success) {
        getProductInx(event, 1);
        $('#exampleModal').modal('hide');
        showToast('Đã thêm ','product '+data.dt['ProductName']);
        $('input[name="productName"]').val('');
      } else {
        
          $('#exampleModal').modal('hide');
          showToast('Không thể thêm ','product do lỗi api');
        }
    },
    error: function(data) {
      console.log(data);
      $('#exampleModal').modal('hide');
      showToast('Không thể thêm ','product do có lỗi');
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
$('textarea[name="Description"]').kendoEditor();
</script>
@endsection
@endsection