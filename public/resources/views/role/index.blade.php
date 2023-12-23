@extends('shared.layoutadmin')
@section('title','Role')
@section('body')
<div class="container-fluid py-4">
      <div class="row">
<div class="col-lg-12 col-md-6 mb-4">
          <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-3 d-flex justify-content-between align-items-center">
                <h6 class="text-white text-capitalize ps-3">Role</h6>
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
                      <th class="text-secondary font-weight-bolder ps-2" id="btn-orderBy" name="ASC">Role name
                      </th>
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
var deleteContent='<label class="text-dark ">Role Name:</label> @csrf <span class="text-dark" name="RoleName"></span>';
createModal('modalDelete', 'frm_delete', '/role/delete', 'Are you sure delete?', deleteContent);
var createContent='<label class="text-dark">Role Name</label> @csrf <input class="text-dark rounded" type="text" name="RoleName" placeholder="enter name...">';
createModal('exampleModal', 'frm_add', '/role/add', 'Create Role', createContent);
var editContent='<label class="text-dark">Role Name</label> @csrf <input class="text-dark rounded" type="text" name="RoleName">';
createModal('modalEdit', 'frm_edit', '/role/edit', 'Edit Role', createContent);


$(document).ready(function() {
    $('#dataTable').DataTable({
        paging: false,  // Tắt phân trang
        lengthChange: false,  // Tắt chọn số lượng hiển thị
        info:false,
        searching:false,
        columnDefs: [
            { orderable: false, targets: [1] }  // Tắt sắp xếp cho cột 1 và 2
        ]
    });
});

$(document).on("click","th[id='btn-orderBy']", function() {
    var order = this.getAttribute("name");
    if(order == "ASC") {
        this.setAttribute("name", "DESC");
        getAllRoleASC(event, 1);
    } else {
        this.setAttribute("name", "ASC");
        getAllRoleASC(event, 1);
    }
});
  function getAllRoleASC(event, $page){
    event.preventDefault();
    var order=document.getElementById("btn-orderBy").getAttribute('name');
    var htmlbd;
    var urla='/role/getAllRole?page='+$page;
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        url: urla,
        type: 'POST',
        data: {
          'orderBy':order,
            _token: '{{csrf_token()}}'
        },
        success: function(response) {
          if(response.success) {
              htmlbd = '';
              $.each(response.arr, function(i, v) {
                  htmlbd += `
                  <tr>
                    <td class="td_input" id="${v.RoleId}">${v.RoleName}</td>
                    <td>
                        <a class="btn btn-warning btn_trash hover-overlay" id="${v.RoleId}" name="${v.RoleName}" data-toggle="tooltip" title="Delete"><i class="bi bi-trash-fill"></i></a>
                        <a class="btn btn-warning btn_edit hover-overlay" id="${v.RoleId}" name="${v.RoleName}" data-toggle="tooltip" title="Edit"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    </tr>`;
              });
              document.getElementById('tablebody').innerHTML = htmlbd;
              var currentPage = $page; // Trang hiện tại
              var lastPage = response.page; // Trang cuối cùng
              if(currentPage==1)
                var pagination = '<li class="page-item disabled "><a class="page-link" style="color: black !important;" href="#" onclick="getAllRoleASC(event, ' + (currentPage) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              else
                var pagination = '<li class="page-item"><a class="page-link" style="color: black !important;" href="#" onclick="getAllRoleASC(event, ' + (currentPage - 1) + ')" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
              for (var i = 1; i <= lastPage; i++) {
                  if (i == currentPage) {
                      // Nếu i là trang hiện tại, tạo một nút được chọn
                      pagination += '<li class="page-item active"><a class="page-link" style="color: black !important;" href="#">' + i + '</a></li>';
                  } else {
                      // Nếu không, tạo một nút bình thường
                      pagination += '<li class="page-item"><a class="page-link" style="color: black !important;" href="#" onclick="getAllRoleASC(event, ' + i + ')">' + i + '</a></li>';
                  }
              }
              if(currentPage==lastPage)
              pagination += '<li class="page-item disabled"><a class="page-link" style="color: black !important;" href="#" onclick="getAllRoleASC(event, ' + (currentPage) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
              else
                pagination += '<li class="page-item"><a class="page-link" style="color: black !important;" href="#" onclick="getAllRoleASC(event, ' + (currentPage + 1) + ')" aria-label="Next"><span aria-hidden="true">»</span></a></li>';
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
    if(kt=='text')
      $('#'+idm+' '+item+'[name="RoleName"]').text(name);
    else
      $('#'+idm+' '+item+'[name="RoleName"]').val(name);
    $('#'+idm+' form').data('id', id);
    $('#'+idm).modal('show');
  });
}
click('.btn_trash','modalDelete','span','text');
click('.btn_edit','modalEdit','input','val');
var edit;
$(document).on('submit','form[name="frm_edit"]', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  var formData = $(this).serialize();
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/role/edit/' + id,
    type: 'POST',
    data: formData,
    success: function(data) {
      edit=$('td.td_input[id="' + id + '"]').text();
      if(data.success == true) {
        var roleName = data.RoleName;
        getAllRoleASC(event, 1);
        $('#modalEdit').modal('hide');
        showToast('Đã chỉnh sửa '+edit,'sang '+roleName);
      } else {
        $('#modalEdit').modal('hide');
        showToast('Không thể sửa ','role '+edit+data.msg);
      }
    }
  });
});
var trash;
$(document).on('submit','form[name="frm_delete"]', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/role/delete/' + id,
    type: 'POST',
    data: { _token: $('input[name="_token"]').val() },
    success: function(data) {
      trash=$('td.td_input[id="' + id + '"]').text();
      if(data.success == true) {
        getAllRoleASC(event, 1);
        $('#modalDelete').modal('hide');
        showToast('Đã xóa ','role '+trash);
      } else {
        $('#modalDelete').modal('hide');
        showToast('Không thể xóa ','role '+trash+data.msg);
      }
    }
  });
});
$('form[name="frm_add"]').on('submit', function(e) {
  e.preventDefault();
  var formData = $(this).serialize();
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: '/role/add',
    type: 'POST',
    data: formData,
    success: function(data) {
      if(data.success == true) {
        getAllRoleASC(event, 1);
        $('#exampleModal').modal('hide');
        showToast('Đã thêm ','role '+data.RoleName);
        $('input[name="RoleName"]').val('');
      } else {
        $('#exampleModal').modal('hide');
        showToast('Không thể thêm ','role đã tồn tại');
      }
    },
    error: function(data) {

      $('#exampleModal').modal('hide');
      showToast('Không thể thêm ','role đã tồn tại');
    }
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
function createModal(modalId, formName, action, title, bodyContent) {
    var modal = document.createElement("div");
    modal.setAttribute("class", "modal fade");
    modal.setAttribute("id", modalId);
    modal.setAttribute("tabindex", "-1");
    modal.setAttribute("aria-labelledby", "exampleModalLabel");
    modal.setAttribute("aria-hidden", "true");
    var modalDialog = document.createElement("div");
    modalDialog.setAttribute("class", "modal-dialog");
    var form = document.createElement("form");
    form.setAttribute("name", formName);
    form.setAttribute("action", action);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("class", "modal-content");
    var modalHeader = document.createElement("div");
    modalHeader.setAttribute("class", "modal-header");
    var h5 = document.createElement("h5");
    h5.setAttribute("class", "modal-title fw-bold text-dark");
    h5.setAttribute("style", "color: #f6c23e !important;");
    h5.setAttribute("id", "exampleModalLabel");
    h5.innerHTML = title;
    var modalBody = document.createElement("div");
    modalBody.setAttribute("class", "modal-body");
    modalBody.innerHTML = bodyContent;
    var modalFooter = document.createElement("div");
    modalFooter.setAttribute("class", "modal-footer");
    var button1 = document.createElement("button");
    button1.setAttribute("type", "button");
    button1.setAttribute("class", "btn btn-danger");
    button1.setAttribute("data-bs-dismiss", "modal");
    button1.value = "no";
    var i1 = document.createElement("i");
    i1.setAttribute("class", "fas fa-times");
    var button2 = document.createElement("button");
    button2.setAttribute("class", "btn btn-warning");
    button2.value = "yes";
    var i2 = document.createElement("i");
    i2.setAttribute("class", "fas fa-check");
    button1.appendChild(i1);
    button2.appendChild(i2);
    modalFooter.appendChild(button1);
    modalFooter.appendChild(button2);
    modalHeader.appendChild(h5);
    form.appendChild(modalHeader);
    form.appendChild(modalBody);
    form.appendChild(modalFooter);
    modalDialog.appendChild(form);
    modal.appendChild(modalDialog);
    document.body.appendChild(modal);
}
window.addEventListener('load', (event) => {
    getAllRoleASC(event, 1);
  });
</script>
@endsection
@endsection




