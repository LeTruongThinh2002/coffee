@extends('shared.layout')
@section('body')
@section('title','User')

<a class="btn btn-warning m-3 ms-0 me-1 hover-overlay shadow" href="/" data-toggle="tooltip" title="Home"><i class="bi bi-house-door-fill"></i></a>
<form class="d-none d-md-inline-block form-inline ms-4 me-1 my-2 my-md-0">    
  <nav class="mt-2" aria-label="Page navigation example">
    <ul class="pagination" id="pagination">
    </ul>
  </nav>
</form>
<div class="bg-light border rounded-3 p-4 pt-2 pb-2">
  <div>
    <table id="dataTable" class="table table-light mb-0 table-hover" style="table-layout: fixed; width: 100%;"><thead>
                <tr>
                    <th id="btn-orderBy" name="ASC">Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Command</th>
                </tr>
            </thead>
            <tbody id="tablebody">
                
            </tbody>
    </table>
  </div>
</div>
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <form name="frm_delete" action="/user/delete" method="post" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-dark" id="exampleModalLabel">Are you sure delete?</h5>
            </div>
            <div class="modal-body">
                <label class="text-dark ">User name:</label> 
                <input type="hidden" name="_token" value="" autocomplete="off"> 
                <span class="text-dark" name="name"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" value="no">
                    <i class="fas fa-rectangle-xmark"></i>
                </button>
                <button class="btn btn-warning" value="yes">
                    <i class="fas fa-square-check"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
  <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
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
  $(document).ready(function() {
    $('#dataTable').DataTable({
        paging:false,
        lengthChange: false,  // Tắt chọn số lượng hiển thị
        info:false,
        columnDefs: [
            { orderable: false, targets: [1, 2, 3] }  // Tắt sắp xếp cho cột 1 và 2
        ]
    });
    $('.dataTables_filter input').on('keyup', function(e) {
      var searchQuery = $(this).val();
      if (searchQuery.length > 0 && searchQuery.trim() != '') {
        getOrderBySearch(e,1);
      }else{
        getOrderBy(event, 1);
      }
    });
});

$(document).on("click","th[id='btn-orderBy']", function() {
    var order = this.getAttribute("name");
    var searchInput= $('.dataTables_filter input').val();
    if(order == "ASC") {
        this.setAttribute("name", "DESC");}
        else{
          this.setAttribute("name", "ASC");
        }
    if(searchInput.length > 0 && searchInput.trim() != ''){
      getOrderBySearch(event,searchInput, 1);}
    else{
      getOrderBy(event, 1);}
});
function getOrderBy(e,$page){
  var order = document.getElementById("btn-orderBy").getAttribute("name");
  getAllUser(event, $page, order);
}
  function getAllUser(event, $page, $orderBy){
    event.preventDefault();
    var htmlbd;
    var urla='/user/getAllUser?page='+$page;
    $.ajax({
        url: urla,
        type: 'POST',
        data: {
          orderBy:$orderBy,
            _token: '{{csrf_token()}}'
        },
        success: function(response) {
          if(response.success) {
              htmlbd = '';
              $.each(response.user, function(i, v) {
                  htmlbd += `
                <tr>
                    <td class="td_input overflow-hidden" id="${v.id}">${v.name}</td>
                    <td class="overflow-hidden">${v.email}</td>
                    <td>
                        <select class="form-select rounded-pill" style="width: fit-content;" id="${v.id}" name="${v.name}">
                            `;
                            $.each(response.crr, function(i, c) {
                              if(c.RoleId==v.role){
                                htmlbd +=`
                                        <option value="selectr" id="${v.role}" selected>${v.roleName}</option>
                                        
                                    `;}else{
                                      htmlbd+=`<option id="${c.RoleId}">${c.RoleName}</option>`;
                                    }
                                  });
                            htmlbd+=`
                        </select>
                    </td>
                    <td>
                        <a class="btn btn-warning btn_trash hover-overlay" id="${v.id}" name="${v.name}" data-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill"></i></a>
                    </td>
                    </tr>
               `;
              });
              document.getElementById('tablebody').innerHTML = htmlbd;
              var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a class="page-link" href="#" onclick="getOrderBy(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" href="#" onclick="getOrderBy(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getOrderBy(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" href="#" onclick="getOrderBy(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getOrderBy(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
    getAllUser(event, 1,"ASC");
  });
  
  function getOrderBySearch(e,$page){
  var searchInfo=$('.dataTables_filter input').val();
  var order = document.getElementById("btn-orderBy").getAttribute("name");
  searchBoxUs(e,searchInfo, $page, order);
}
  function searchBoxUs(e,searchQuery,$page,$orderBy){
    e.preventDefault();
    $.ajax({
          url: '/user/searchBoxUs?page='+$page+'&orderBy='+$orderBy, // Thay đổi thành endpoint của bạn
          type: 'POST',
          data: {
            'q': searchQuery,
              _token: '{{csrf_token()}}' // Thêm CSRF token vào đây
          },
          success: function(response) {
            if(response.success) {
              searchInfo=searchQuery;
              var htmlbd = '';
              $.each(response.user, function(i, v) {
                  htmlbd += `
                <tr>
                    <td class="td_input overflow-hidden" id="${v.id}">${v.name}</td>
                    <td class="overflow-hidden">${v.email}</td>
                    <td>
                        <select class="form-select rounded-pill" style="width: fit-content;" id="${v.id}" name="${v.name}">
                            `;
                            $.each(response.crr, function(i, c) {
                              if(c.RoleId==v.role){
                                htmlbd +=`
                                        <option value="selectr" id="${v.role}" selected>${v.roleName}</option>
                                        
                                    `;}else{
                                      htmlbd+=`<option id="${c.RoleId}">${c.RoleName}</option>`;
                                    }
                                  });
                            htmlbd+=`
                        </select>
                    </td>
                    <td>
                        <a class="btn btn-warning btn_trash hover-overlay" id="${v.id}" name="${v.name}" data-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill"></i></a>
                    </td>
                    </tr>
               `;
              });
                if(htmlbd==''){
                  htmlbd+='Khong tim thay ket qua phu hop';
                }
                document.getElementById('tablebody').innerHTML = htmlbd;
                var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled"><a class="page-link" href="#" onclick="getOrderBySearch(event ,' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" href="#" onclick="getOrderBySearch(event ,' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getOrderBySearch(event ,' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" href="#" onclick="getOrderBySearch(event ,' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" href="#" onclick="getOrderBySearch(event ,' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
  }

  function showToast(active,name) {
  $('#liveToast div.toast-body').text(active+' thành công '+name+'!');
  $('#liveToast').toast('show');
  startTime = new Date();
  updateTime();
  setInterval(updateTime, 1000);
};
    $(document).on('click', '.btn_trash', function() {
    var name = $(this).attr('name');
    var id = $(this).attr('id');
    var id_log=$('#id-log').attr('name');
    if(id==id_log){
      showToast('Không thể xóa','user đang đăng nhập');
    }else{
    $('#modalDelete span[name="name"]').text(name);
    $('#modalDelete form').data('id', id);
    $('#modalDelete').modal('show');}
  });
  var trash;
$(document).on('submit','form[name="frm_delete"]', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    url: '/user/delete/' + id,
    type: 'POST',
    data: { _token: $('input[name="_token"]').val() },
    success: function(data) {
      if(data.success == true) {
        trash=$('td.td_input[id="' + id + '"]').text();
        $('a.btn_trash[id="' + id + '"]').closest('tr').remove();
        $('#modalDelete').modal('hide');
        showToast('Đã xóa ','user '+trash);
      } else {
        showToast('Không thể xóa','user đang đăng nhập');
      }
    }
  });
});
$(document).on('change','.form-select', function(e) {
  e.preventDefault();
    var id = $(this).attr('id');
    var RoleId = $(this).children("option:selected").attr('id');
    var name = $(this).attr('name');
    var id_log=$('#id-log').attr('name');
    $.ajax({
        url: '/user/edit/' + id,
        type: 'POST',
        data: {
            _token: $('input[name="_token"]').val(),
            RoleId: RoleId,
            idlog: id_log
        },
        success: function(data) {
            if (data.success==true) {
              console.log(id);
              console.log(id_log);
              console.log(RoleId);
                showToast('Đã chỉnh sửa role của '+name,'');
                console.log(data);
            }else{
              console.log(id);
              console.log(id_log);
              console.log(RoleId);
              showToast('Không thể chỉnh sửa','user đang đăng nhập');
              const $select = document.querySelector(`select[id="${id}"]`);
              $select.value = 'selectr';

            }
        }
    })
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